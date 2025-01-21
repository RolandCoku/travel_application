// Hero slideshow initialization
const heroSwiper = new Swiper('.myHeroSwiper', {
    loop: true,
    autoplay: {
        delay: 4000,
    },
    speed: 800,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});