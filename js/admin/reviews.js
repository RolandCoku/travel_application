document.addEventListener("DOMContentLoaded", () => {

    // Highlight active sidebar link
    highlightActiveSidebarLink(".sidebar a");

    const reviewsTableBody = document.getElementById("reviews-table-body");
    const recentUpdatesContainer = document.querySelector(".recent-updates");

    // Fetch and display reviews
    const fetchReviews = async (page = 1, limit = 10) => {
        try {
            const { currentPage, totalPages, data } = await fetchData(`/api/admin/reviews?action=paginate&page=${page}&limit=${limit}`);
            displayReviews(data);
            setupPagination("#pagination-container", currentPage, totalPages, (pageToFetch) => {
                if (pageToFetch > 0 && pageToFetch <= totalPages) {
                    fetchReviews(pageToFetch, limit);
                }
            });
        } catch (error) {
            reviewsTableBody.innerHTML = "<tr><td colspan='6'>Error loading reviews</td></tr>";
        }
    };

    // Fetch and display latest reviews
    const fetchLatestReviews = async (limit = 5) => {
        try {
            return await fetchData(`/api/admin/reviews?action=latest&limit=${limit}`);
        } catch (error) {
            console.error("Error fetching latest reviews:", error);
            return {};
        }
    };

    // Display reviews in the table
    const displayReviews = (reviews) => {
        reviewsTableBody.innerHTML = ""; // Clear existing rows

        if (!reviews || Object.keys(reviews).length === 0) {
            reviewsTableBody.innerHTML = "<tr><td colspan='6'>No reviews found</td></tr>";
            return;
        }

        Object.values(reviews).forEach((review) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${review.reviews_id}</td>
                <td>${review.users_name}</td>
                <td>${review.travel_packages_name}</td>
                <td>${review.comment}</td>
                <td>${review.rating}</td>
                <td>
                    <div class="dropdown">
                        <i class="bx bx-menu dropdown-button"></i>
                        <div class="dropdown-content">
                            <a href="/admin/reviews/edit/${review.reviews_id}" class="edit">Edit</a>
                            <a href="/admin/reviews/delete/${review.reviews_id}" class="delete">Delete</a>
                        </div>
                    </div>
                </td>
            `;
            reviewsTableBody.appendChild(row);
        });
    };

    // Display latest reviews in the recent updates section
    const displayLatestReviews = (reviews) => {
        recentUpdatesContainer.innerHTML = "<h2>Latest Reviews</h2>"; // Clear existing content

        if (!reviews || Object.keys(reviews).length === 0) {
            recentUpdatesContainer.innerHTML += "<p class='text-muted'>No recent updates available</p>";
            return;
        }

        Object.values(reviews).forEach(({ travel_packages_name, comment, users_name, reviews_created_at }) => {
            const updateElement = document.createElement("div");
            updateElement.classList.add("update");
            updateElement.innerHTML = `
                <p><b>${users_name}</b> left a review for <b>${travel_packages_name}</b>: "${comment}"</p>
                <small class="text-muted">${new Date(reviews_created_at).toLocaleString()}</small>
            `;
            recentUpdatesContainer.appendChild(updateElement);
        });
    };

    // Initial fetch
    fetchReviews()
        .then(() => fetchLatestReviews().then(displayLatestReviews))
        .catch(error => console.error("Error during initial fetch:", error));

    // Handle dropdown actions
    handleDropdownActions();
});
