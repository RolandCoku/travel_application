<?php
if (isset($agency)) {
    $title = 'Elite Travel | ' . $agency['name'];
}
$cssFiles = [
    'user/travel-agency/show.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body>
<!-- Navbar -->
<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('/img/<?= $agency['main_image']['image_url'] ?>');">
    <div class="dark-overlay"></div> <!-- Add a dark overlay for better text contrast -->
    <div class="hero-content">
        <h1><?= $agency['name'] ?></h1>
        <p><?= $agency['description'] ?></p>
    </div>
</section>


<!-- Agency Details -->
<section class="agency-details-section">
    <div class="container">
        <div class="agency-card">
            <div class="card-image">
                <img src="/img/<?= $agency['main_image']['image_url'] ?>"
                     alt="<?= $agency['main_image']['alt_text'] ?>"
                     loading="lazy">
            </div>
            <div class="card-content">
                <h2><?= $agency['name'] ?></h2>
                <p><?= $agency['description'] ?></p>
                <p><strong>Website:</strong> <a href="<?= $agency['website'] ?>" target="_blank"><?= $agency['website'] ?></a></p>
                <p><strong>Address:</strong> <?= $agency['address'] ?></p>
                <p><strong>Phone:</strong> <?= $agency['phone'] ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Travel Packages -->
<section class="travel-packages-section">
    <div class="container">
        <h2>Available Travel Packages</h2>
        <div class="package-grid">
            <?php foreach ($agency['travel_packages'] as $package): ?>
                <div class="card package-card">
                    <div class="card-image">
                        <img src="/img/<?= $package['main_image']['image_url'] ?? 'assets/placeholder-image.webp' ?>"
                             alt="<?= $package['main_image']['alt_text'] ?? 'Package Image' ?>"
                             loading="lazy">
                    </div>
                    <div class="card-content">
                        <h3><?= $package['name'] ?></h3>
                        <p><?= $package['description'] ?></p>
                        <div class="location-container">
                            <strong>Location:</strong> <?= $package['location'] ?>
                        </div>
                        <p><strong>Duration:</strong> <?= $package['start_date'] ?> to <?= $package['end_date'] ?></p>
                        <p><strong>Price:</strong> $<?= $package['price'] ?></p>
                        <p><strong>Available Seats:</strong> <?= $package['seats'] - $package['occupied_seats'] ?></p>
                        <p><strong>Rating:</strong> <?= str_repeat('⭐', $package['reviews']['average_rating']) ?: 'No ratings yet' ?></p>
                        <a href="/bookings/create/?travel_package_id=<?= $package['id'] ?>" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php require_once app_path('includes/layout-footer.php'); ?>
</body>
