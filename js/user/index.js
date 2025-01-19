document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/agencies')
        .then(response => response.json())
        .then(data => {
            const swiperWrapper = document.querySelector('.swiper-wrapper');
            swiperWrapper.innerHTML = '';
            data.forEach(agency => {
                const slide = document.createElement('div');
                slide.classList.add('swiper-slide');
                slide.innerHTML = `
                <img src="${agency.image || '/img/assets/agencies/agency-1.webp'}" alt="${agency.name}" loading="lazy">
                <div class="agency-content">
                    <h3>${agency.name}</h3>
                    <p>${agency.description}</p>
                    <p><strong>Address:</strong> ${agency.address}</p>
                    <p><strong>Phone:</strong> ${agency.phone}</p>
                </div>
            `;
                swiperWrapper.appendChild(slide);
            });
        })
        .catch(error => console.error('Error fetching agency data:', error));
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

// Agencies Swiper
const agencySwiper = new Swiper('.swiper-agency', {
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