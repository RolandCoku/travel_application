document.addEventListener("DOMContentLoaded", () => {
    const usersTableBody = document.getElementById("users-table-body");
    const recentUpdatesContainer = document.querySelector(".recent-updates");
    const salesAnalyticsContainer = document.querySelector(".sales-analytics");

    // Fetch and display users
    const fetchUsers = async (page = 1, limit = 10) => {
        try {
            const { currentPage, totalPages, data } = await fetchData(`/api/admin/users?action=paginate&page=${page}&limit=${limit}`);
            displayUsers(data);
            setupPagination("#pagination-container", currentPage, totalPages, fetchUsers);
        } catch (error) {
            usersTableBody.innerHTML = "<tr><td colspan='6'>Error loading users</td></tr>";
        }
    };

    const fetchLatestLogs = async (limit = 5) => {
        try {
            return await fetchData(`/api/admin/logs?action=latest&limit=${limit}`);
        } catch (error) {
            console.error("Error fetching latest logs:", error);
            return [];
        }
    };

    const fetchTopDestinations = async (limit = 5) => {
        try {
            return await fetchData(`/api/admin/bookings?action=topDestinations&limit=${limit}`);
        } catch (error) {
            console.error("Error fetching top destinations:", error);
            return [];
        }
    };

    const countUsersByDateRange = async (start_date, end_date) => {
        try {
            return await fetchData(`/api/admin/users?action=countByDate&start_date=${start_date}&end_date=${end_date}`);
        } catch (error) {
            console.error("Error counting users by date range:", error);
            return 0;
        }
    };

    const countBookingsByDateRange = async (start_date, end_date) => {
        try {
            return await fetchData(`/api/admin/bookings?action=countByDate&start_date=${start_date}&end_date=${end_date}`);
        } catch (error) {
            console.error("Error counting bookings by date range:", error);
            return 0;
        }
    };

    const displayUsers = (users) => {
        usersTableBody.innerHTML = ""; // Clear existing rows

        if (!users || Object.keys(users).length === 0) {
            usersTableBody.innerHTML = "<tr><td colspan='6'>No users found</td></tr>";
            return;
        }

        Object.values(users).forEach((user) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td><span class='${user.email_confirmed ? "success" : "warning"}'>${user.email_confirmed ? "Confirmed" : "Pending"}</span></td>
                <td>
                    <div class="dropdown">
                        <i class="bx bx-menu dropdown-button"></i>
                        <div class="dropdown-content">
                            <a href="/admin/users/edit" class="edit">Edit</a>
                            <a href="/admin/users/delete" class="delete">Delete</a>
                        </div>
                    </div>
                </td>
            `;
            usersTableBody.appendChild(row);
        });
    };

    const displayLatestLogs = (logs) => {
        recentUpdatesContainer.innerHTML = "<h2>Latest Updates</h2>"; // Clear existing logs

        if (!logs || Object.keys(logs).length === 0) {
            recentUpdatesContainer.innerHTML += "<p class='text-muted'>No recent updates available</p>";
            return;
        }

        Object.values(logs).forEach(({ log, user }) => {
            const updateElement = document.createElement("div");
            updateElement.classList.add("update");
            updateElement.innerHTML = `
                <p><b>${user.name}</b> (${user.email}) ${log.action}.</p>
                <small class="text-muted">${new Date(log.created_at).toLocaleString()}</small>
            `;
            recentUpdatesContainer.appendChild(updateElement);
        });
    };

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

    const updateCardCounts = async () => {
        try {
            const lastWeek = new Date();
            lastWeek.setDate(lastWeek.getDate() - 7);

            const startDate = lastWeek.toISOString().split("T")[0];
            const endDate = new Date().toISOString().split("T")[0];

            document.querySelector(".new-users h1").textContent = await countUsersByDateRange(startDate, endDate);
            document.querySelector(".bookings h1").textContent = await countBookingsByDateRange(startDate, endDate);
        } catch (error) {
            console.error("Error updating card counts:", error);
            document.querySelector(".new-users h1").textContent = "Error";
            document.querySelector(".bookings h1").textContent = "Error";
        }
    };

    highlightActiveSidebarLink(".sidebar a");
    fetchUsers()
        .then(() => fetchLatestLogs().then(displayLatestLogs))
        .then(() => fetchTopDestinations().then(displayTopDestinations))
        .then(() => updateCardCounts());
    handleDropdownActions();
});
