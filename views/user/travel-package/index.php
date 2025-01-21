<?php
$title = 'Elite Travel | Packages';
$cssFiles = [
    'user/travel-package/index.css?=v' . time()
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

<!-- Hero / Banner -->
<section class="packages-hero">
    <div class="hero-content">
        <h1>Discover Our Amazing Packages</h1>
        <p>Multiple categories and multiple rows of your favorite travel deals!</p>
    </div>
</section>

<!-- Book and Leave Swiper (swiper-closest) -->
<section class="section-packages" id="by-agency">
    <h2>Book and Leave</h2>
    <div class="swiper swiper-closest">
        <div class="swiper-wrapper">
            <!-- Slides will be dynamically added here -->
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Most Liked Packages Swiper (swiper-most-liked) -->
<section class="section-packages" id="most-liked">
    <h2>Most Liked Packages</h2>
    <div class="swiper swiper-most-liked">
        <div class="swiper-wrapper">
            <!-- Slides will be dynamically added here -->
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- New Packages Swiper (swiper-new-packages) -->
<section class="section-packages" id="new-packages">
    <h2>New Packages</h2>
    <div class="swiper swiper-new-packages">
        <div class="swiper-wrapper">
            <!-- Slides will be dynamically added here -->
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="logo">
                <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Footer Logo">
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
    'https://unpkg.com/swiper/swiper-bundle.min.js',
];
$jsFiles = [
    'user/travel-package/index.js?=v' . time()
];
require_once app_path('includes/layout-footer.php');
?>
</body>
