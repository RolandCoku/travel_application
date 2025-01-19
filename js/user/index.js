document.addEventListener('DOMContentLoaded', function () {
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
                </div>
            `;

            swiperContainer.appendChild(slide); // Add slide to the Swiper container
        });

        swiper.update(); // Update Swiper with new slides
    };

    // Initialize Swiper
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
            slideChange: () => {
                // Slide change logic (if any) can be added here
            }
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

    // Initial fetch
    fetchAndAppendAgencies(currentPage, limit).then(() => {
        // Initial fetch completed
    });
});


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

// Packages Swiper
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
    }
});
