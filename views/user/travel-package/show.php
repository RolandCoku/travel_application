<?php require_once app_path('includes/layout-header.php'); ?>

<!-- This view is used to display a single travel package -->

<div class="container">
    <h1 class="text-center">Travel Package</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title"><?= $travelPackage['name'] ?></h5>
                    <p class="card-text"><?= $travelPackage['description'] ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Start Date: <?= $travelPackage['start_date'] ?></small>
                        <small class="text-muted">End Date: <?= $travelPackage['end_date'] ?></small>
                        <small class="text-muted">Price: <?= $travelPackage['price'] ?></small>
                    </div>
                    <div class="btn-group mt-3">
                        <a href="/bookings/create?travel_package_id=<?= $travelPackage['id'] ?>" class="btn btn-sm btn-outline-secondary">Book</a>
                    </div>

                    <div class="mt-3">
                        <h5>Reviews</h5>
                        <ul class="list-group">
                            <?php if (isset($reviews)) {
                                foreach ($reviews as $review): ?>
                                    <li class="list-group-item"><?= $review['comment'] ?></li>
                                <?php endforeach;
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once app_path('includes/layout-footer.php'); ?>

