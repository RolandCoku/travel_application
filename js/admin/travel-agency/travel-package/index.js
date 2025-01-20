document.addEventListener("DOMContentLoaded", () => {

  // Highlight active sidebar link
  highlightActiveSidebarLink(".sidebar a");

  const travelPackagesTableBody = document.getElementById("travel-packages-table-body");
  const salesAnalyticsContainer = document.querySelector(".sales-analytics");

  // Fetch and display travel packages
  const fetchTravelPackages = async (page = 1, limit = 10) => {
      try {
          const { currentPage, totalPages, data } = await fetchData(`/api/travel-agency/travel-packages?action=paginate&page=${page}&limit=${limit}`);
          displayTravelPackages(data);
          setupPagination("#pagination-container", currentPage, totalPages, (pageToFetch) => {
              if (pageToFetch > 0 && pageToFetch <= totalPages) {
                  fetchTravelPackages(pageToFetch, limit);
              }
          });
      } catch (error) {
          travelPackagesTableBody.innerHTML = "<tr><td colspan='9'>Error loading travel packages</td></tr>";
      }
  };

  // Fetch top travel packages
  const fetchTopPackages = async (limit = 5) => {
      try {
          return await fetchData(`/api/travel-agency/travel-packages?action=topPackages&limit=${limit}`);
      } catch (error) {
          console.error("Error fetching top travel packages:", error);
          return [];
      }
  };

  // Display travel packages in the table
  const displayTravelPackages = (packages) => {
      travelPackagesTableBody.innerHTML = ""; // Clear existing rows

      if (!packages || Object.keys(packages).length === 0) {
          travelPackagesTableBody.innerHTML = "<tr><td colspan='9'>No travel packages found</td></tr>";
          return;
      }

      Object.values(packages).forEach((pkg) => {
          const row = document.createElement("tr");
          row.innerHTML = `
              <td>${pkg.travel_packages_name}</td>
              <td>${pkg.travel_packages_description	}</td>
              <td>${pkg.price}</td>
              <td>${new Date(pkg.start_date).toLocaleDateString()} - ${new Date(pkg.end_date).toLocaleDateString()}</td>
              <td>${new Date(pkg.end_date).getDate() - new Date(pkg.start_date).getDate()} days</td>
              <td>${pkg.seats}</td>
              <td>${pkg.occupied_seats || 'N/A'}</td>
              <td>
                  <div class="dropdown">
                      <i class="bx bx-menu dropdown-button"></i>
                      <div class="dropdown-content">
                          <a href="/travel-agency/admin/travel-packages/edit?id=${pkg.travel_packages_id}" class="edit">Edit</a>
                          <a href="/travel-agency/admin/travel-packages/update?id=${pkg.travel_packages_id}" class="delete">Delete</a>
                      </div>
                  </div>
              </td>
          `;
          travelPackagesTableBody.appendChild(row);
      });
  };

  // Display top travel packages in the sales analytics section
  const displayTopPackages = (packages) => {
      salesAnalyticsContainer.innerHTML = "<h2>Top Packages</h2>";

      if (!packages || packages.length === 0) {
          salesAnalyticsContainer.innerHTML = "<p>No top packages found</p>";
          return;
      }

      packages.forEach(({ name, total_reviews, average_rating }) => {
          const packageElement = document.createElement("div");
          packageElement.classList.add("item");
          packageElement.innerHTML = `
          <div>
              <h3>${name}</h3>
              <p>${total_reviews} reviews with an average rating of ${average_rating} stars</p>
          </div>
      `;
          salesAnalyticsContainer.appendChild(packageElement);
      });
  };

  // Initial fetch
  fetchTravelPackages()
      .then(() => fetchTopPackages().then(displayTopPackages))
      .catch(error => console.error("Error during initial fetch:", error));

  // Handle dropdown actions
  handleDropdownActions();
});
