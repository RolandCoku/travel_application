<?php
$title = 'Elite Travel | About Us';
$cssFiles = [
    'user/about-us.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body>
<!-- Navbar -->
<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="dark-overlay"></div>
    <div class="hero-content">
        <h1>About Us</h1>
        <p>Discover who we are and why Elite Travel is your best choice for amazing travel experiences.</p>
    </div>
</section>

<!-- About Us Section -->
<section class="about-us-section">
    <div class="container">
        <h2>Who We Are</h2>
        <p>
            At Elite Travel, we believe in crafting unforgettable travel experiences for adventurers, families, and wanderers.
            With a network of trusted agencies and carefully curated packages, we ensure every journey is personalized,
            enjoyable, and seamless.
        </p>
        <p>
            Our mission is to connect you with the world's wonders through reliable agencies and thoughtfully designed travel
            solutions. With years of expertise and a passion for exploration, Elite Travel has become a trusted name in the
            travel industry.
        </p>
    </div>
</section>

<!-- Our Story Section -->
<section class="our-story-section">
    <div class="container">
        <h2>Our Story</h2>
        <div class="story-content">
            <div class="image-container">
                <img src="<?= base_url('img/assets/home/mountain-landscape-3.webp') ?>" alt="Our Story Image">
            </div>
            <div class="text-container">
                <p>
                    It all began with a dream to make travel accessible and effortless for everyone. From humble beginnings as a
                    small startup, we have grown into a trusted platform connecting travelers with agencies worldwide. Our journey
                    has been fueled by the passion to create exceptional travel experiences and memories that last a lifetime.
                </p>
                <p>
                    Today, Elite Travel stands as a beacon of trust, reliability, and innovation in the travel industry. We take
                    pride in the relationships we have built with agencies, our commitment to quality, and the trust of countless
                    happy travelers.
                </p>
            </div>
        </div>
    </div>
</section>

<?php require_once app_path('includes/user-footer.php'); ?>

<!-- Footer -->
<?php require_once app_path('includes/layout-footer.php'); ?>
</body>
