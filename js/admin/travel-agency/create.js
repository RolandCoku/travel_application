document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("email");
    const suggestionsContainer = document.getElementById("suggestions-container");
    const form = document.getElementById("create-agency-form");

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
        suggestionsContainer.innerHTML = "";
        if (users.length === 0) {
            suggestionsContainer.style.display = "none";
            return;
        }

        users.forEach((user) => {
            const suggestionItem = document.createElement("div");
            suggestionItem.classList.add("suggestion-item");
            suggestionItem.textContent = `${user.name} (${user.email}) (${user.role})`;
            suggestionItem.dataset.email = user.email;

            suggestionItem.addEventListener("click", () => {
                searchInput.value = user.email;
                suggestionsContainer.style.display = "none";
            });

            suggestionsContainer.appendChild(suggestionItem);
        });

        suggestionsContainer.style.display = "block";
    };

    searchInput.addEventListener("input", (event) => {
        const query = event.target.value;

        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                fetchUsers(query).catch(console.error);
            } else {
                suggestionsContainer.style.display = "none";
            }
        }, 300);
    });

    document.addEventListener("click", (event) => {
        if (!event.target.closest(".form-group")) {
            suggestionsContainer.style.display = "none";
        }
    });

    // Helper function to show error messages
    const showError = (input, message) => {
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains("error-message")) {
            errorElement = document.createElement("div");
            errorElement.classList.add("error-message");
            input.parentElement.appendChild(errorElement);
        }
        errorElement.textContent = message;
    };

    // Helper function to clear error messages
    const clearError = (input) => {
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains("error-message")) {
            errorElement.remove();
        }
    };

    // Frontend validation
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const email = document.getElementById("email");
        const name = document.getElementById("name");
        const description = document.getElementById("description");
        const address = document.getElementById("address");
        const phone = document.getElementById("phone");
        const website = document.getElementById("website");

        let isValid = true;

        // Validate email
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            isValid = false;
            showError(email, "Please enter a valid email address.");
        } else {
            clearError(email);
        }

        // Validate name
        if (name.value.trim().length < 3) {
            isValid = false;
            showError(name, "Agency name must be at least 3 characters long.");
        } else {
            clearError(name);
        }

        // Validate description
        if (description.value.trim().length < 10) {
            isValid = false;
            showError(description, "Description must be at least 10 characters long.");
        } else {
            clearError(description);
        }

        // Validate address
        if (address.value.trim().length < 5) {
            isValid = false;
            showError(address, "Address must be at least 5 characters long.");
        } else {
            clearError(address);
        }

        // Validate phone
        if (!/^\d{7,15}$/.test(phone.value.trim())) {
            isValid = false;
            showError(phone, "Phone number must be between 7 and 15 digits.");
        } else {
            clearError(phone);
        }

        // Validate website
        if (!/^https?:\/\/[^\s$.?#].[^\s]*$/.test(website.value.trim())) {
            isValid = false;
            showError(website, "Please enter a valid website URL.");
        } else {
            clearError(website);
        }

        // Submit the form if all validations pass
        if (isValid) {
            form.submit();
        }
    });
});
