document.addEventListener("DOMContentLoaded", () => {
    handleActiveSidebarLink(".sidebar a");

    const travelPackagesTableBody = document.getElementById("travel-packages-table-body");
    const paginationContainer = document.getElementById("pagination-container");

    // Fetch travel packages with pagination
    const fetchTravelPackages = async (page = 1, limit = 10) => {
        try {
            const response = await fetch(`/api/travel-agency/travel-packages?action=paginate&page=${page}&limit=${limit}`);
            const { currentPage, totalPages, data } = await response.json();

            displayTravelPackages(data);
            setupPagination(currentPage, totalPages, (pageToFetch) => {
                if (pageToFetch > 0 && pageToFetch <= totalPages) {
                    fetchTravelPackages(pageToFetch, limit);
                }
            });
        } catch (error) {
            console.error("Error fetching travel packages:", error);
            travelPackagesTableBody.innerHTML = "<tr><td colspan='7'>Error loading travel packages</td></tr>";
        }
    };

    // Display travel packages in the table
    const displayTravelPackages = (packages) => {
        travelPackagesTableBody.innerHTML = ""; // Clear existing rows

        if (!packages || Object.keys(packages).length === 0) {
            travelPackagesTableBody.innerHTML = "<tr><td colspan='7'>No travel packages found</td></tr>";
            return;
        }

        Object.values(packages).forEach((pkg) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${pkg.id}</td>
                <td>${pkg.name}</td>
                <td>${pkg.description}</td>
                <td>${pkg.price} €</td>
                <td>${new Date(pkg.start_date).toLocaleDateString()} - ${new Date(pkg.end_date).toLocaleDateString()}</td>
                <td>${Math.max(0, new Date(pkg.end_date) - new Date(pkg.start_date)) / (1000 * 60 * 60 * 24)} days</td>
                <td>${pkg.free_seats || 'N/A'}</td>
                <td>
                    <div class="dropdown">
                        <i class="bx bx-menu dropdown-button"></i>
                        <div class="dropdown-content">
                            <a href="/travel-agency/admin/travel-packages/edit/${pkg.id}" class="edit">Edit</a>
                            <a href="/travel-agency/admin/travel-packages/delete/${pkg.id}" class="delete">Delete</a>
                        </div>
                    </div>
                </td>
            `;
            travelPackagesTableBody.appendChild(row);
        });
    };

    // Set up pagination controls
    const setupPagination = (currentPage, totalPages, onPageClick) => {
        paginationContainer.innerHTML = ""; // Clear existing pagination

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.textContent = i;
            button.className = `pagination-button ${i === currentPage ? "active" : ""}`;
            button.addEventListener("click", () => onPageClick(i));
            paginationContainer.appendChild(button);
        }
    };

    // Initial fetch
    fetchTravelPackages();
});
