<?php
$title = 'Elite Travel | Home';
$cssFiles = [
    'user/index.css?=v' . time()
];
$links = [
    'https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css',
    'https://unpkg.com/swiper/swiper-bundle.min.css'
];

require_once app_path('includes/layout-header.php');
?>
<body>
<!-- Navbar -->

<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- Hero Section (Swiper Slideshow) -->
<section class="hero-section">
    <div class="swiper-container myHeroSwiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide" style="background-image:  url('/img/assets/home/lake-view-1.webp'); background-position: center | center; ">
                <div class="caption">Explore the world with us</div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide" style="background-image: url('/img/assets/home/lake-view-2.webp');">
                <div class="caption">Your adventure begins here</div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide" style="background-image: url('/img/assets/home/mountain-landscape-1.webp');">
                <div class="caption">Discover new destinations</div>
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide" style="background-image: url('/img/assets/home/mountain-landscape-2.webp');">
                <div class="caption">Experience the extraordinary</div>
            </div>
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Featured Agencies (Horizontal Slider) -->
<section class="section-agency" id="agencies">
    <h2>Featured Agency</h2>
    <div class="swiper swiper-agency">
        <div class="swiper-wrapper">
            <!-- Agencies cards will be dynamically added here -->
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Featured Travel Packages (Horizontal Slider) -->
<section class="section-packages" id="travel-packages">
    <h2>Featured Travel Packages</h2>
    <div class="swiper swiper-packages">
        <div class="swiper-wrapper">
            <!-- Travel packages cards will be dynamically added here -->
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Reviews -->
<section class="review-container" id="reviews">
    <div class="container-left">
        <h2>Read what our customers love about us</h2>
        <p>Over 200 companies from diverse sectors consult us to enhance the user experience and revenue with our services.</p>
        <p>We have helped companies increase their customer base and generate multiple revenue streams with our expertise.</p>
        <button>Read Our Success Story</button>
    </div>
    <div class="container-right">
        <div class="card">
            <img
                    src="https://cdni.iconscout.com/illustration/premium/thumb/woman-profile-illustration-download-in-svg-png-gif-file-formats--young-female-girl-avatar-portraits-pack-people-illustrations-6590622.png?f=webp"
                    alt="Anna Smith"
            />
            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "Fantastic service and memorable trips! Elite Travel made booking easy and tailored everything to my preferences.
                        Highly recommend for a stress-free vacation!"
                    </p>
                    <h4>- Anna Smith</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <img
                    src="https://st3.depositphotos.com/15648834/17930/v/450/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
                    alt="Land Johnson"
            />
            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "User-friendly and efficient! The Elite Travel Agency made booking my trip a breeze. It’s easy to navigate, offers
                        great recommendations, and I love the real-time updates. Highly recommend for hassle-free travel planning!"
                    </p>
                    <h4>- Land Johnson</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="logo">
                <img src="<?= BASE_URL . 'img/assets/full-logo.png' ?>" alt="Footer Logo">
            </div>
            <nav class="footer-links">
                <a href="/about">About Us</a>
                <a href="/contact">Contact</a>
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </nav>
        </div>
        <p>&copy; <span>2025</span> Elite Travel. All Rights Reserved.</p>
    </div>
</footer>

<?php

$externalScripts = [
    'https://unpkg.com/swiper/swiper-bundle.min.js'
];

$jsFiles = [
    '/user/index.js?=v' . time()
];
require_once app_path('includes/layout-footer.php');
?>

