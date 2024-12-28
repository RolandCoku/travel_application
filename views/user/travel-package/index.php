<?php require_once app_path('includes/layout-header.php'); ?>

<div class="container">
    <h1 class="text-center">Travel Packages</h1>
    <div class="row">
        <?php if (isset($travelPackages)) {
            foreach ($travelPackages as $travelPackage): ?>
                <div class="col-md-4">
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
                                <a href="/travel-packages/show/?id=<?= $travelPackage['id'] ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="/travel-packages/edit/?id=<?= $travelPackage['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="/travel-packages/destroy/?id=<?= $travelPackage['id'] ?>" class="btn btn-sm btn-outline-secondary">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        } ?>
    </div>
</div>

<?php require_once app_path('includes/layout-footer.php'); ?>
