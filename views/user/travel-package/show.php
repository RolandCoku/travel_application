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
            <?php if (!empty($package['secondary_images'])): ?>
                <?php foreach ($package['secondary_images'] as $image): ?>
                    <div
                            class="swiper-slide"
                            style="background-image: url('/img/<?php echo htmlspecialchars($image['image_url']); ?>');"
                    >
                        <!-- Dark overlay for text contrast -->
                        <div class="dark-overlay"></div>
                        <!-- Content -->
                        <div class="hero-content">
                            <h1><?php echo htmlspecialchars($package['name']); ?></h1>
                            <p><?php echo htmlspecialchars($package['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Slide if no secondary images are available -->
                <div
                        class="swiper-slide"
                        style="background-image: url('https://via.placeholder.com/1920x800?text=No+Image+Available');"
                >
                    <div class="dark-overlay"></div>
                    <div class="hero-content">
                        <h1><?php echo htmlspecialchars($package['name']); ?></h1>
                        <p><?php echo htmlspecialchars($package['description']); ?></p>
                    </div>
                </div>
            <?php endif; ?>
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
        <h2><?php echo htmlspecialchars($package['name']); ?> Getaway</h2>
        <!-- Key data points -->
        <div class="details-item">
            <span>Location:</span>
            <p><?php echo htmlspecialchars($package['location']); ?></p>
        </div>
        <div class="details-item">
            <span>Price:</span>
            <p>$<?php echo htmlspecialchars($package['price']); ?></p>
        </div>
        <div class="details-item">
            <span>Seats Available:</span>
            <p><?php echo htmlspecialchars($package['free_seats']); ?></p>
        </div>
        <div class="details-item">
            <span>Start Date:</span>
            <p><?php echo htmlspecialchars($package['start_date']); ?></p>
        </div>
        <div class="details-item">
            <span>End Date:</span>
            <p><?php echo htmlspecialchars($package['end_date']); ?></p>
        </div>

        <div class="details-item">
            <span>Agency:</span>
            <p><?php echo htmlspecialchars($package['agency']['name']); ?></p>
        </div>

        <div class="details-item">
            <span>Rating:</span>
            <p>
                <?php
                // Display average rating with one decimal
                echo number_format($package['average_rating'], 1) . "/5";
                ?>
            </p>
        </div>

        <!-- Book Now Button / Form -->
        <div class="booking-cta">
            <a href="/bookings/create?travel_package_id=<?php echo $package['id'] ?>">Book Now</a>
        </div>
    </div>

    <!-- Right column: longer description, reviews, etc. -->
    <div class="details-right">
        <div class="long-description">
            <h3>About This Package</h3>
            <p>
                <?php echo nl2br(htmlspecialchars($package['description'])); ?>
            </p>
        </div>

        <!-- Reviews section -->
        <div class="reviews-section">
            <h3>Reviews</h3>

            <?php if (!empty($package['reviews'])): ?>
                <?php foreach ($package['reviews'] as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <img
                                    src="/img/assets/users/<?php echo htmlspecialchars($review['user']['avatar'] ?? 'placeholder.webp'); ?>"
                                    alt="<?php echo htmlspecialchars($review['user']['name']); ?>'s Avatar"
                            />
                            <div class="review-author"><?php echo htmlspecialchars($review['user']['name']); ?></div>
                        </div>
                        <div class="review-body">
                            <!-- Display rating stars -->
                            <div class="review-rating">
                                <?php
                                $rating = (int)$review['rating'];
                                for ($i = 1; $i <= 5; $i++):
                                    if ($i <= $rating): ?>
                                        <i class="ri-star-fill" style="color: #FFD700;"></i>
                                    <?php else: ?>
                                        <i class="ri-star-line" style="color: #FFD700;"></i>
                                    <?php endif;
                                endfor;
                                ?>
                            </div>
                            <p><?php echo htmlspecialchars($review['comment']); ?></p>
                            <span class="review-date"><?php echo htmlspecialchars(date('F j, Y', strtotime($review['created_at']))); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review this package!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Package Gallery Section -->
<div class="package-gallery">
    <h3>More Views of the Destination</h3>
    <div class="gallery-grid">
        <?php if (!empty($package['secondary_images'])): ?>
            <?php foreach ($package['secondary_images'] as $image): ?>
                <img src="/img/assets/packages/<?php echo htmlspecialchars($image['image_url']); ?>" alt="<?php echo htmlspecialchars($image['alt_text']); ?>">
            <?php endforeach; ?>
        <?php else: ?>
            <img src="https://via.placeholder.com/600x400?text=No+Image+Available" alt="No Image Available">
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php require_once app_path('includes/user-footer.php'); ?>

<?php

$externalScripts = [
    'https://unpkg.com/swiper/swiper-bundle.min.js',
];

$jsFiles = [
    '/user/travel-package/show.js?=v' . time(),
];

require_once app_path('includes/layout-footer.php');

?>
