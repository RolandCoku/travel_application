<?php require_once app_path('includes/layout-header.php'); ?>

<!-- Ask user to confirm their email address by entering a code received on the email -->
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <h1>Confirm your email</h1>
            <form method="post">
                <div class="form-group
                    <?php if (isset($errors['code'])): ?>
                        has-error
                    <?php endif; ?>
                ">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="<?= $_POST['code'] ?? '' ?>">
                    <?php if (isset($errors['code'])): ?>
                        <p class="help-block
                            <?php if ($errors['code'] === 'Invalid code'): ?>
                                text-danger
                            <?php else: ?>
                                text-warning
                            <?php endif; ?>
                        ">
                            <?= $errors['code'] ?>
                        </p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </form>
        </div>
    </div>
</div>
<?php require_once app_path('includes/layout-footer.php'); ?>
