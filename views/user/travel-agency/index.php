<?php
$title = 'Elite Travel | Agencies';
$cssFiles = [
    'user/travel-agency/index.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body>
<!-- Navbar -->
<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Explore Our Trusted Agencies</h1>
        <p>Find the best agencies to plan your next adventure.</p>
    </div>
</section>

<!-- Agencies Section -->
<section class="agencies-section">
    <div class="container">
        <h2>Find the best agencies</h2>
        <div class="agency-grid">
            <?php if (isset($agencies)) {
                foreach ($agencies as $agency): ?>
                    <div class="card agency-card">
                        <div class="card-image">
                            <img src="/img/<?= $agency['main_image']['image_url'] ?? 'assets/placeholder-image.webp' ?>"
                                 alt="<?= $agency['main_image']['alt_text'] ?? 'Agency Image' ?>">
                        </div>
                        <div class="card-content">
                            <h3><?= $agency['name'] ?></h3>
                            <p><?= $agency['description'] ?></p>
                            <p><strong>Address:</strong> <?= $agency['address'] ?></p>
                            <p><strong>Phone:</strong> <?= $agency['phone'] ?></p>
                            <a href="/travel-agencies/show?id=<?= $agency['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                <?php endforeach;
            } ?>
        </div>
    </div>
</section>

<?php require_once app_path('includes/user-footer.php'); ?>

<!-- Footer -->
<?php require_once app_path('includes/layout-footer.php'); ?>
</body>
