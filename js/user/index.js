document.addEventListener('DOMContentLoaded', function () {
    // Agencies Swiper
    const swiperContainer = document.querySelector('.swiper-agency .swiper-wrapper');
    let currentPage = 1; // Current page to fetch
    const limit = 16; // Number of agencies to fetch per request
    let totalPages = 0; // Total pages available, updated after each fetch
    let fetching = false; // Prevent multiple fetches at the same time

    // Fetch agencies from the API
    const fetchAndAppendAgencies = async (page, limit) => {
        try {
            const response = await fetch(`/api/travel-agencies?action=getPaginatedWithImages&page=${page}&limit=${limit}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();

            let { currentPage: fetchedPage, totalPages: fetchedTotalPages, data } = result;

            // Parse as integers to avoid string comparison issues
            fetchedPage = parseInt(fetchedPage, 10);
            fetchedTotalPages = parseInt(fetchedTotalPages, 10);

            if (!isNaN(fetchedPage) && !isNaN(fetchedTotalPages)) {
                totalPages = fetchedTotalPages;
                appendAgenciesToSwiper(data);
                currentPage = fetchedPage + 1;
            } else {
                console.error("Invalid pagination data received from API");
            }
        } catch (error) {
            console.error('Error fetching agencies:', error);
        }
    };

    // Append agencies to Swiper
    const appendAgenciesToSwiper = (agencies) => {
        Object.values(agencies).forEach((agency) => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');

            const imageUrl = agency.image_url
                ? `/img/${agency.image_url}`
                : '/img/assets/placeholder-image.webp';

            slide.innerHTML = `
            <img src="${imageUrl}" alt="${agency.alt_text || 'Agency Image'}" loading="lazy">
            <div class="agency-content">
                <h3>${agency.name}</h3>
                <p>${agency.description}</p>
                <p><strong>Address:</strong> ${agency.address}</p>
                <p><strong>Phone:</strong> ${agency.phone}</p>
                <a href="/travel-agencies/show?id=${agency.id}" class="btn btn-primary show-more-button">Show More</a>
            </div>
        `;
            swiperContainer.appendChild(slide); // Add slide to the Swiper container
        });

        swiper.update(); // Update Swiper with new slides
    };

    // Initialize Swiper for agencies
    const swiper = new Swiper('.swiper-agency', {
        preloadImages: false,
        lazy: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        loop: false,
        speed: 800,
        grid: {
            rows: 2,
            fill: 'row'
        },
        on: {
            reachEnd: async () => {
                if (fetching || currentPage > totalPages) {
                    return;
                }
                fetching = true;
                await fetchAndAppendAgencies(currentPage, limit);
                fetching = false;
            },
        },
        slidesPerView: 4,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-agency .swiper-button-next',
            prevEl: '.swiper-agency .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-agency .swiper-pagination',
            clickable: true
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
    });

    // Initial fetch for agencies
    fetchAndAppendAgencies(currentPage, limit);

    // Packages Swiper
    const packagesSwiperContainer = document.querySelector('.swiper-packages .swiper-wrapper');
    let currentPackagePage = 1; // Current page to fetch for travel packages
    const packageLimit = 16; // Number of packages to fetch per request
    let totalPackagePages = 0; // Total pages available for packages
    let fetchingPackages = false; // Prevent multiple fetches at the same time

    // Fetch travel packages from the API
    const fetchAndAppendPackages = async (page, limit) => {
        try {
            const response = await fetch(`/api/travel-packages?action=getPaginatedWithImages&page=${page}&limit=${limit}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();

            let { currentPage: fetchedPage, totalPages: fetchedTotalPages, data } = result;

            // Parse as integers to avoid string comparison issues
            fetchedPage = parseInt(fetchedPage, 10);
            fetchedTotalPages = parseInt(fetchedTotalPages, 10);

            if (!isNaN(fetchedPage) && !isNaN(fetchedTotalPages)) {
                totalPackagePages = fetchedTotalPages;
                appendPackagesToSwiper(data);
                currentPackagePage = fetchedPage + 1;
            } else {
                console.error("Invalid pagination data received from API");
            }
        } catch (error) {
            console.error('Error fetching travel packages:', error);
        }
    };

// Append travel packages to Swiper
    const appendPackagesToSwiper = (packages) => {
        Object.values(packages).forEach((pkg) => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');

            const imageUrl = pkg.main_image.image_url
                ? `/img/${pkg.main_image.image_url}`
                : '/img/assets/placeholder-image.webp';

            slide.innerHTML = `
        <img src="${imageUrl}" alt="${pkg.main_image.alt_text || 'Package Image'}" loading="lazy">
        <div class="package-content">
            <h3>${pkg.name}</h3>
            <p>${pkg.description}</p>
            <div class="location-container">
                <span class="location-icon ri-map-pin-line"></span>
                <p>${pkg.location || 'Location not specified'}</p>
            </div>
            <p><strong>Start Date:</strong> ${pkg.start_date}</p>
            <p><strong>End Date:</strong> ${pkg.end_date}</p>
            <p><strong>Price:</strong> $${pkg.price}</p>
            <p><strong>Free Seats:</strong> ${pkg.free_seats}</p>
            <a href="/bookings/create/?travel_package_id=${pkg.id}" class="btn btn-primary show-more-button">Book now</a>
        </div>
    `;

            packagesSwiperContainer.appendChild(slide); // Add slide to the Swiper container
        });

        packagesSwiper.update(); // Update Swiper with new slides
    };

    // Initialize Swiper for packages
    const packagesSwiper = new Swiper('.swiper-packages', {
        preloadImages: false,
        lazy: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        loop: false,
        speed: 800,
        grid: {
            rows: 2,
            fill: 'row'
        },
        on: {
            reachEnd: async () => {
                if (fetchingPackages || currentPackagePage > totalPackagePages) {
                    return;
                }
                fetchingPackages = true;
                await fetchAndAppendPackages(currentPackagePage, packageLimit);
                fetchingPackages = false;
            },
        },
        slidesPerView: 4,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-packages .swiper-button-next',
            prevEl: '.swiper-packages .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-packages .swiper-pagination',
            clickable: true
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
    });

    // Initial fetch for travel packages
    fetchAndAppendPackages(currentPackagePage, packageLimit);

    // Hero Swiper
    const heroSwiper = new Swiper('.myHeroSwiper', {
        preloadImages: false,
        lazy: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        loop: true,
        autoplay: {
            delay: 5000,
        },
        speed: 800,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
});
