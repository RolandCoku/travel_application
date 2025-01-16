document.addEventListener("DOMContentLoaded", () => {
    highlightActiveSidebarLink(".sidebar a");
    const agenciesTableBody = document.getElementById("agencies-table-body");
    const salesAnalyticsContainer = document.querySelector(".sales-analytics");

    // Fetch and display agencies
    const fetchAgencies = async (page = 1, limit = 10) => {
        try {
            const { currentPage, totalPages, data } = await fetchData(`/api/travel-agencies?action=paginate&page=${page}&limit=${limit}`);
            displayAgencies(data);
            setupPagination("#pagination-container", currentPage, totalPages, fetchAgencies);
        } catch (error) {
            agenciesTableBody.innerHTML = "<tr><td colspan='7'>Error loading agencies</td></tr>";
        }
    };

    // Fetch top agencies
    const fetchTopAgencies = async (limit = 5) => {
        try {
            return await fetchData(`/api/travel-agencies?action=topAgencies&limit=${limit}`);
        } catch (error) {
            console.error("Error fetching top agencies:", error);
            return [];
        }
    };

    // Display agencies in the table
    const displayAgencies = (agencies) => {
        agenciesTableBody.innerHTML = ""; // Clear existing rows

        if (!agencies || Object.keys(agencies).length === 0) {
            agenciesTableBody.innerHTML = "<tr><td colspan='7'>No agencies found</td></tr>";
            return;
        }

        Object.values(agencies).forEach((agency) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${agency.id}</td>
                <td>${agency.name}</td>
                <td>${agency.email}</td>
                <td>${agency.address}</td>
                <td>${agency.phone}</td>
                <td><a href="${agency.website}" target="_blank">${agency.website}</a></td>
                <td>
                    <div class="dropdown">
                        <i class="bx bx-menu dropdown-button"></i>
                        <div class="dropdown-content">
                            <a href="/admin/agencies/edit/${agency.id}" class="edit">Edit</a>
                            <a href="/admin/agencies/delete/${agency.id}" class="delete">Delete</a>
                        </div>
                    </div>
                </td>
            `;
            agenciesTableBody.appendChild(row);
        });
    };

// Display top agencies
    const displayTopAgencies = (agencies) => {
        salesAnalyticsContainer.innerHTML = "<h2>Top Agencies</h2>"; // Clear existing content

        if (!agencies || Object.keys(agencies).length === 0) {
            salesAnalyticsContainer.innerHTML += "<p class='text-muted'>No top agencies available</p>";
            return;
        }

        Object.values(agencies).forEach(({ name, bookings }) => {
            const agencyElement = document.createElement("div");
            agencyElement.classList.add("item");
            agencyElement.innerHTML = `
            <div>
                <h3>${name}</h3>
                <p>${bookings} bookings</p>
            </div>
        `;
            salesAnalyticsContainer.appendChild(agencyElement);
        });
    };

    // Initial fetch
    fetchAgencies()
        .then(() => fetchTopAgencies().then(displayTopAgencies));

    // Handle dropdown for the actions menu
    handleDropdownActions();

});
