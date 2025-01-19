document.addEventListener("DOMContentLoaded", () => {

  // Highlight active sidebar link
  highlightActiveSidebarLink(".sidebar a");

  const bookingsTableBody = document.getElementById("agencies-table-body");
  const salesAnalyticsContainer = document.querySelector(".sales-analytics");

  // Fetch and display bookings
  const fetchBookings = async (page = 1, limit = 10) => {
    try {
      const { currentPage, totalPages, data } = await fetchData(`/api/travel-agency/bookings?action=paginate&page=${page}&limit=${limit}`);
      console.log(data);
      displayBookings(data);
      setupPagination("#pagination-container", currentPage, totalPages, fetchBookings);
    } catch (error) {
      bookingsTableBody.innerHTML = "<tr><td colspan='7'>Error loading bookings</td></tr>";
    }
  };

  // Fetch top destinations
  const fetchTopDestinations = async (limit = 5) => {
    try {
      return await fetchData(`/api/travel-agency/bookings?action=topDestinations&limit=${limit}`);
    } catch (error) {
      console.error("Error fetching top destinations:", error);
      return [];
    }
  };

  // Display bookings in the table
  const displayBookings = (bookings) => {
    bookingsTableBody.innerHTML = ""; // Clear existing rows

    if (!bookings || bookings.length === 0) {
      bookingsTableBody.innerHTML = "<tr><td colspan='8'>No bookings found</td></tr>";
      return;
    }
    bookings.forEach((booking) => {
      const row = document.createElement("tr");
      row.innerHTML = `
          <td>${booking.users_name}</td>
          <td>${booking.email}</td>
          <td>${booking.travel_packages_name}</td>
          <td>${new Date(booking.booking_date).toLocaleDateString()}</td>
          <td>${booking.booking_status}</td>
          <td>${booking.payments_amount}</td>
          <td>${booking.payments_payment_status}</td>
          <td>
              <div class="dropdown">
                  <i class="bx bx-menu dropdown-button"></i>
                  <div class="dropdown-content">
                      <a href="/admin/bookings/edit/${booking.bookings_id}" class="edit">Edit</a>
                      <a href="/admin/bookings/delete/${booking.bookings_id}" class="delete">Delete</a>
                  </div>
              </div>
          </td>
      `;
      bookingsTableBody.appendChild(row);
    });
  };

  // Display top destinations
  const displayTopDestinations = (destinations) => {
    salesAnalyticsContainer.innerHTML = "<h2>Top Destinations</h2>"; // Clear existing content

    if (!destinations || destinations.length === 0) {
      salesAnalyticsContainer.innerHTML += "<p class='text-muted'>No top destinations available</p>";
      return;
    }

    destinations.forEach(({ name, bookings }) => {
      const destinationElement = document.createElement("div");
      destinationElement.classList.add("item");
      destinationElement.innerHTML = `
              <div>
                  <h3>${name}</h3>
                  <p>${bookings} bookings</p>
              </div>
          `;
      salesAnalyticsContainer.appendChild(destinationElement);
    });
  };

  // Initial fetch
  fetchBookings()
    .then(() => fetchTopDestinations().then(displayTopDestinations))
    .catch(error => console.error("Error during initial fetch:", error));

  // Handle dropdown actions
  handleDropdownActions();
});