document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("email");
    const suggestionsContainer = document.getElementById("suggestions-container");
    let searchTimeout = null;

    const fetchUsers = async (query) => {
        try {
            const url = `/api/admin/users?action=search&search_query=${encodeURIComponent(query)}&limit=5`;
            const users = await fetchData(url);
            updateSuggestions(users);
        } catch (error) {
            console.error("Error fetching user suggestions:", error);
        }
    };

    const updateSuggestions = (users) => {
        // Clear existing suggestions
        suggestionsContainer.innerHTML = "";
        if (users.length === 0) {
            suggestionsContainer.style.display = "none";
            return;
        }

        // Populate suggestions
        users.forEach((user) => {
            const suggestionItem = document.createElement("div");
            suggestionItem.classList.add("suggestion-item");
            suggestionItem.textContent = `${user.name} (${user.email}) (${user.role})`;
            suggestionItem.dataset.email = user.email;

            // Add click event to select email
            suggestionItem.addEventListener("click", () => {
                searchInput.value = user.email;
                suggestionsContainer.style.display = "none";
            });

            suggestionsContainer.appendChild(suggestionItem);
        });

        // Show the suggestions container
        suggestionsContainer.style.display = "block";
    };

    searchInput.addEventListener("input", (event) => {
        const query = event.target.value;

        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        // Add a small debounce to avoid too many API calls
        searchTimeout = setTimeout(() => {
            if (query.length >= 2) { // Trigger only if query length >= 2
                fetchUsers(query).catch(console.error);
            } else {
                suggestionsContainer.style.display = "none"; // Hide suggestions for empty or short queries
            }
        }, 300);
    });

    // Close suggestions when clicking outside
    document.addEventListener("click", (event) => {
        if (!event.target.closest(".form-group")) {
            suggestionsContainer.style.display = "none";
        }
    });
});
