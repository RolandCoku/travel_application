document.addEventListener('DOMContentLoaded', function () {
    /* =======================
       Book and Leave Swiper (swiper-closest)
       ======================= */
    const bookAndLeaveSwiperContainer = document.querySelector('.swiper-closest .swiper-wrapper');
    let currentPageClosest = 1;
    const limitClosest = 10;
    let totalPagesClosest = 0;
    let fetchingClosest = false;

    // Fetch and append Book and Leave packages
    const fetchAndAppendClosestPackages = async (page, limit) => {
        try {
            fetchingClosest = true;
            const response = await fetch(`/api/travel-packages?action=closest&page=${page}&limit=${limit}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const result = await response.json();

            const { currentPage: fetchedPage, totalPages: fetchedTotalPages, data } = result;

            const parsedPage = parseInt(fetchedPage, 10);
            const parsedTotalPages = parseInt(fetchedTotalPages, 10);

            if (!isNaN(parsedPage) && !isNaN(parsedTotalPages)) {
                totalPagesClosest = parsedTotalPages;
                appendClosestPackagesToSwiper(data);
                currentPageClosest = parsedPage + 1;
            } else {
                console.error("Invalid pagination data received from API for Closest Packages");
            }
        } catch (error) {
            console.error('Error fetching Book and Leave packages:', error);
        } finally {
            fetchingClosest = false;
        }
    };

    // Append Book and Leave packages to Swiper
    const appendClosestPackagesToSwiper = (packages) => {
        packages.forEach((pkg) => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');

            // Determine image URL and alt text
            let imageUrl = '/img/assets/placeholder-image.webp';
            let altText = 'Package Image';

            if (pkg.main_image && typeof pkg.main_image === 'object' && pkg.main_image.image_url) {
                imageUrl = `/img/assets/agencies/${pkg.main_image.image_url}`;
                altText = pkg.main_image.alt_text || 'Package Image';
            }

            slide.innerHTML = `
                <img src="${imageUrl}" alt="${altText}" loading="lazy">
                <div class="package-content">
                    <h3>${pkg.name}</h3>
                    <p>${pkg.description}</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>${pkg.location || 'Location not specified'}</p>
                    </div>
                    <p><strong>Duration:</strong> ${pkg.start_date} - ${pkg.end_date}</p>
                    <p><strong>Price:</strong> $${pkg.price}</p>
                    <p><strong>Free Seats:</strong> ${pkg.free_seats}</p>
                    <a href="/package/${pkg.id}" class="btn btn-primary show-more-button">Book now</a>
                </div>
            `;

            bookAndLeaveSwiperContainer.appendChild(slide);
        });

        // Update Swiper
        bookAndLeaveSwiper.update();
    };

    // Initialize Swiper for Book and Leave
    const bookAndLeaveSwiper = new Swiper('.swiper-closest', {
        loop: false,
        speed: 600,
        grid: {
            rows: 2,
            fill: 'row',
        },
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-closest .swiper-button-next',
            prevEl: '.swiper-closest .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-closest .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        },
        on: {
            reachEnd: async () => {
                if (fetchingClosest || currentPageClosest > totalPagesClosest) {
                    return;
                }
                await fetchAndAppendClosestPackages(currentPageClosest, limitClosest);
            }
        }
    });

    // Initial fetch for Book and Leave
    fetchAndAppendClosestPackages(currentPageClosest, limitClosest);


    /* =======================
       Most Liked Packages Swiper (swiper-most-liked)
       ======================= */
    const mostLikedSwiperContainer = document.querySelector('.swiper-most-liked .swiper-wrapper');
    let currentPageTop = 1;
    const limitTop = 10;
    let totalPagesTop = 0;
    let fetchingTop = false;

    // Fetch and append Most Liked packages
    const fetchAndAppendTopPackages = async (page, limit) => {
        try {
            fetchingTop = true;
            const response = await fetch(`/api/travel-packages?action=topPackages&page=${page}&limit=${limit}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const result = await response.json();

            const { currentPage: fetchedPage, totalPages: fetchedTotalPages, data } = result;

            const parsedPage = parseInt(fetchedPage, 10);
            const parsedTotalPages = parseInt(fetchedTotalPages, 10);

            if (!isNaN(parsedPage) && !isNaN(parsedTotalPages)) {
                totalPagesTop = parsedTotalPages;
                appendTopPackagesToSwiper(data);
                currentPageTop = parsedPage + 1;
            } else {
                console.error("Invalid pagination data received from API for Top Packages");
            }
        } catch (error) {
            console.error('Error fetching Most Liked packages:', error);
        } finally {
            fetchingTop = false;
        }
    };

    // Append Most Liked packages to Swiper
    const appendTopPackagesToSwiper = (packages) => {
        packages.forEach((pkg) => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');

            // Determine image URL and alt text
            let imageUrl = '/img/assets/placeholder-image.webp';
            let altText = 'Package Image';

            if (pkg.main_image && typeof pkg.main_image === 'object' && pkg.main_image.image_url) {
                imageUrl = `/img/assets/agencies/${pkg.main_image.image_url}`;
                altText = pkg.main_image.alt_text || 'Package Image';
            }

            // Generate star ratings
            let starsHtml = '';
            const maxStars = 5;
            const filledStars = pkg.average_rating || 0;
            for (let i = 1; i <= maxStars; i++) {
                if (i <= filledStars) {
                    starsHtml += `<i class="ri-star-fill" style="color: #FFD700;"></i>`;
                } else {
                    starsHtml += `<i class="ri-star-line" style="color: #FFD700;"></i>`;
                }
            }

            slide.innerHTML = `
                <img src="${imageUrl}" alt="${altText}" loading="lazy">
                <div class="package-content">
                    <h3>${pkg.name}</h3>
                    <p>${pkg.description}</p>
                    <div class="rating">
                        ${starsHtml}
                    </div>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>${pkg.location || 'Location not specified'}</p>
                    </div>
                    <p><strong>Duration:</strong> ${pkg.start_date} - ${pkg.end_date}</p>
                    <p><strong>Price:</strong> $${pkg.price}</p>
                    <p><strong>Free Seats:</strong> ${pkg.free_seats}</p>
                    <a href="/package/${pkg.id}" class="btn btn-primary show-more-button">Book now</a>
                </div>
            `;

            mostLikedSwiperContainer.appendChild(slide);
        });

        // Update Swiper
        mostLikedSwiper.update();
    };

    // Initialize Swiper for Most Liked Packages
    const mostLikedSwiper = new Swiper('.swiper-most-liked', {
        loop: false,
        speed: 600,
        grid: {
            rows: 2,
            fill: 'row',
        },
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-most-liked .swiper-button-next',
            prevEl: '.swiper-most-liked .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-most-liked .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        },
        on: {
            reachEnd: async () => {
                if (fetchingTop || currentPageTop > totalPagesTop) {
                    return;
                }
                await fetchAndAppendTopPackages(currentPageTop, limitTop);
            }
        }
    });

    // Initial fetch for Most Liked Packages
    fetchAndAppendTopPackages(currentPageTop, limitTop);


    /* =======================
       New Packages Swiper (swiper-new-packages)
       ======================= */
    const newPackagesSwiperContainer = document.querySelector('.swiper-new-packages .swiper-wrapper');
    let currentPageLatest = 1;
    const limitLatest = 10;
    let totalPagesLatest = 0;
    let fetchingLatest = false;

    // Fetch and append New packages
    const fetchAndAppendLatestPackages = async (page, limit) => {
        try {
            fetchingLatest = true;
            const response = await fetch(`/api/travel-packages?action=latest&page=${page}&limit=${limit}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const result = await response.json();

            const { currentPage: fetchedPage, totalPages: fetchedTotalPages, data } = result;

            const parsedPage = parseInt(fetchedPage, 10);
            const parsedTotalPages = parseInt(fetchedTotalPages, 10);

            if (!isNaN(parsedPage) && !isNaN(parsedTotalPages)) {
                totalPagesLatest = parsedTotalPages;
                appendLatestPackagesToSwiper(data);
                currentPageLatest = parsedPage + 1;
            } else {
                console.error("Invalid pagination data received from API for Latest Packages");
            }
        } catch (error) {
            console.error('Error fetching New Packages:', error);
        } finally {
            fetchingLatest = false;
        }
    };

    // Append New packages to Swiper
    const appendLatestPackagesToSwiper = (packages) => {
        packages.forEach((pkg) => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');

            // Determine image URL and alt text
            let imageUrl = '/img/assets/placeholder-image.webp';
            let altText = 'Package Image';

            if (pkg.main_image && typeof pkg.main_image === 'object' && pkg.main_image.image_url) {
                imageUrl = `/img/assets/agencies/${pkg.main_image.image_url}`;
                altText = pkg.main_image.alt_text || 'Package Image';
            }

            slide.innerHTML = `
                <img src="${imageUrl}" alt="${altText}" loading="lazy">
                <div class="package-content">
                    <h3>${pkg.name}</h3>
                    <p>${pkg.description}</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>${pkg.location || 'Location not specified'}</p>
                    </div>
                    <p><strong>Duration:</strong> ${pkg.start_date} - ${pkg.end_date}</p>
                    <p><strong>Price:</strong> $${pkg.price}</p>
                    <p><strong>Free Seats:</strong> ${pkg.free_seats}</p>
                    <a href="/package/${pkg.id}" class="btn btn-primary show-more-button">Book now</a>
                </div>
            `;

            newPackagesSwiperContainer.appendChild(slide);
        });

        // Update Swiper
        newPackagesSwiper.update();
    };

    // Initialize Swiper for New Packages
    const newPackagesSwiper = new Swiper('.swiper-new-packages', {
        loop: false,
        speed: 600,
        grid: {
            rows: 2,
            fill: 'row',
        },
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-new-packages .swiper-button-next',
            prevEl: '.swiper-new-packages .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-new-packages .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        },
        on: {
            reachEnd: async () => {
                if (fetchingLatest || currentPageLatest > totalPagesLatest) {
                    return;
                }
                await fetchAndAppendLatestPackages(currentPageLatest, limitLatest);
            }
        }
    });

    // Initial fetch for New Packages
    fetchAndAppendLatestPackages(currentPageLatest, limitLatest);
});
