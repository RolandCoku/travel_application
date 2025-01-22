// General fetch function
const fetchData = async (
    url,
    method = "GET",
    headers = { "Content-Type": "application/json" },
    credentials = "include"
) => {
    try {
        // Prepare fetch options
        const options = {
            method,
            headers,
            credentials
        };

        // Include the body for POST/PUT requests
        if (body && (method === "POST" || method === "PUT")) {
            options.body = JSON.stringify(body);
        }

        // Perform the fetch request
        const response = await fetch(url, options);

        // Handle non-OK responses
        if (!response.ok) {
            throw new Error(`Failed to fetch data from ${url}: ${response.statusText}`);
        }

        // Parse and return JSON response
        return await response.json();
    } catch (error) {
        console.error(`Error fetching data from ${url}:`, error);
        throw error; // Re-throw the error for caller to handle
    }
};


// Highlight active sidebar link
const highlightActiveSidebarLink = (sidebarSelector) => {
    const sidebarLinks = document.querySelectorAll(sidebarSelector);
    const currentPath = window.location.pathname;

    sidebarLinks.forEach(link => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
};

// Create pagination buttons
const setupPagination = (paginationContainerSelector, currentPage, totalPages, fetchPageCallback) => {
    const paginationContainer = document.querySelector(paginationContainerSelector);
    paginationContainer.innerHTML = ""; // Clear existing pagination

    const createButton = (page, text, disabled) => {
        const button = document.createElement("button");
        button.textContent = text || page;
        button.disabled = disabled;
        button.addEventListener("click", () => fetchPageCallback(page));
        return button;
    };

    // Previous button
    paginationContainer.appendChild(createButton(currentPage - 1, "Previous", currentPage === 1));

    // First page button
    paginationContainer.appendChild(createButton(1));

    // Ellipsis before range
    if (currentPage > 3) {
        const dots = document.createElement("span");
        dots.textContent = "...";
        paginationContainer.appendChild(dots);
    }

    // Middle page range
    const rangeStart = Math.max(2, currentPage - 1);
    const rangeEnd = Math.min(totalPages - 1, currentPage + 1);

    for (let page = rangeStart; page <= rangeEnd; page++) {
        paginationContainer.appendChild(createButton(page, null, page === currentPage));
    }

    // Ellipsis after range
    if (currentPage < totalPages - 2) {
        const dots = document.createElement("span");
        dots.textContent = "...";
        paginationContainer.appendChild(dots);
    }

    // Last page button
    if (totalPages > 1) {
        paginationContainer.appendChild(createButton(totalPages));
    }

    // Next button
    paginationContainer.appendChild(createButton(currentPage + 1, "Next", currentPage === totalPages));
};

// Handle dropdown actions
const handleDropdownActions = () => {
    document.addEventListener("click", (event) => {
        const dropdowns = document.querySelectorAll(".dropdown");
        const button = event.target.closest(".dropdown-button");
        const dropdown = event.target.closest(".dropdown");

        if (button) {
            // Toggle the clicked dropdown
            dropdown?.classList.toggle("show");

            // Close other open dropdowns
            dropdowns.forEach((otherDropdown) => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.classList.remove("show");
                }
            });
        } else {
            // Close all dropdowns if clicked outside
            dropdowns.forEach((otherDropdown) => {
                otherDropdown.classList.remove("show");
            });
        }
    });
};
