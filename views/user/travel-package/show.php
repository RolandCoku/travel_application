<?php

$title = 'Travel Package Details';

$cssFiles = [
    '/user/travel-package/show.css?=v' . time(),
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

<!-- Hero Section with Swiper Slideshow -->
<section class="package-hero">
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+1');"
            >
                <!-- Dark overlay for text contrast -->
                <div class="dark-overlay"></div>
                <!-- Content -->
                <div class="hero-content">
                    <!-- Dynamically replace these with the package's name or tagline if you want -->
                    <h1><!-- <?php echo $package['name']; ?> -->Tropical Paradise</h1>
                    <p>Discover the beauty of crystal clear waters and sandy beaches.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+2');"
            >
                <div class="dark-overlay"></div>
                <div class="hero-content">
                    <h1>Tropical Paradise</h1>
                    <p>Unforgettable sunsets await you.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+3');"
            >
                <div class="dark-overlay"></div>
                <div class="hero-content">
                    <h1>Tropical Paradise</h1>
                    <p>Explore island wonders with us.</p>
                </div>
            </div>
            <!-- More slides if needed -->
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Package Details -->
<div class="package-details">
    <!-- Left column: highlights (price, seats, start/end, booking) -->
    <div class="details-left">
        <h2><!-- <?php echo $package['name']; ?> -->Tropical Paradise Getaway</h2>
        <!-- Key data points -->
        <div class="details-item">
            <span>Location:</span>
            <p><!-- <?php echo $package['location']; ?> -->Maldives</p>
        </div>
        <div class="details-item">
            <span>Price:</span>
            <p>$<!-- <?php echo $package['price']; ?> -->1299.00</p>
        </div>
        <div class="details-item">
            <span>Seats Available:</span>
            <p>
                <!-- seats - occupied_seats -->
                12
            </p>
        </div>
        <div class="details-item">
            <span>Start Date:</span>
            <p><!-- <?php echo $package['start_date']; ?> -->2025-07-10</p>
        </div>
        <div class="details-item">
            <span>End Date:</span>
            <p><!-- <?php echo $package['end_date']; ?> -->2025-07-15</p>
        </div>

        <div class="details-item">
            <span>Agency:</span>
            <p><!-- <?php echo $agency['name']; ?> -->Elite Travel Agency</p>
        </div>

        <div class="details-item">
            <span>Rating:</span>
            <p>4.8/5</p>
        </div>


        <!-- Book Now Button / Form -->
        <div class="booking-cta">
            <form action="/book-package" method="POST" style="display:inline;">
                <!-- In real app: handle CSRF, pass package_id, etc. -->
                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>

    <!-- Right column: longer description, reviews, etc. -->
    <div class="details-right">
        <div class="long-description">
            <h3>About This Package</h3>
            <p>
                <!-- <?php echo nl2br($package['description']); ?> -->
                Escape to an exotic island paradise, where the waters are crystal clear and the sands are pristine white. Enjoy luxurious accommodations, thrilling water sports, and world-class dining as you bask in the tropical sun. From snorkeling through vibrant coral reefs to relaxing in an oceanfront cabana, this experience will leave you rejuvenated and inspired.
            </p>
        </div>

        <!-- Reviews section -->
        <div class="reviews-section">
            <h3>Reviews</h3>

            <!-- Example of looping through reviews -->
            <div class="review-card">
                <div class="review-header">
                    <img
                            src="https://via.placeholder.com/50?text=User"
                            alt="Reviewer Avatar"
                    />
                    <div class="review-author">John Doe</div>
                </div>
                <div class="review-body">
                    "Incredible trip! The beaches were stunning and the resort was top-notch. Highly recommend!"
                </div>
            </div>
            <div class="review-card">
                <div class="review-header">
                    <img
                            src="https://via.placeholder.com/50?text=User"
                            alt="Reviewer Avatar"
                    />
                    <div class="review-author">Jane Smith</div>
                </div>
                <div class="review-body">
                    "Absolutely loved the water activities and the staff were so helpful. Everything was perfect!"
                </div>
            </div>
            <!-- More reviews here, or an "Add Review" form -->
        </div>
    </div>
</div>

<!-- Package Gallery Section -->
<div class="package-gallery">
    <h3>More Views of the Destination</h3>
    <div class="gallery-grid">
        <!-- Replace with actual image URLs / dynamic data -->
        <img src="https://via.placeholder.com/600x400?text=Resort+View" alt="Resort View">
        <img src="https://via.placeholder.com/600x400?text=Beach+Sunset" alt="Beach Sunset">
        <img src="https://via.placeholder.com/600x400?text=Coral+Reef" alt="Coral Reef">
        <img src="https://via.placeholder.com/600x400?text=Outdoor+Lounge" alt="Outdoor Lounge">
        <!-- Add more as needed -->
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="logo">
                <!-- Replace with your actual logo -->
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
    '/user/travel-package/show.js?=v' . time(),
];

require_once app_path('includes/layout-footer.php');

?>
