<?php require_once app_path('includes/layout-header.php'); ?>

<!-- This view is used to edit a travel package -->

<div class="container">
    <h1 class="text-center">Edit Travel Package</h1>
    <div class="row">
        <div class="col-md-12">
            <form action="/travel-packages/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $travelPackage['id'] ?>">
                <div class="form-group row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $travelPackage['name'] ?>" required>
                    </div>
                    <div class="col">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="<?= $travelPackage['price'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $travelPackage['start_date'] ?>" required>
                    </div>
                    <div class="col">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $travelPackage['end_date'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="agency_id">Agency</label>
                        <select name="agency_id" id="agency_id" class="form-control" required>
                            <option value="">Select Agency</option>
                            <?php if (isset($agencies)) {
                                foreach ($agencies as $agency): ?>
                                    <option value="<?= $agency['id'] ?>" <?= $agency['id'] === $travelPackage['agency_id'] ? 'selected' : '' ?>><?= $agency['name'] ?></option>
                                <?php endforeach;
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required><?= $travelPackage['description'] ?></textarea>
                    </div>
                </div>

                <!-- Show the current image -->
                <div class="form-group row">
                    <div class="col col-2">
                        <label>Current Image</label>
                        <img src="<?= base_url('img/') . $travelPackage['images'][0]['image_url'] ?>" alt="<?= $travelPackage['images'][0]['alt_text'] ?>" class="img-fluid">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" >
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once app_path('includes/layout-footer.php'); ?>
