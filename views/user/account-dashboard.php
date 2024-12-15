<?php require_once app_path('includes/layout-header.php'); ?>

<h1>Account Dashboard</h1>

<!-- Display user email -->
<p>Welcome, <?php echo $_SESSION['user_email']; ?></p>

<!-- Logout button -->
<form action="/logout" method="post">
    <button type="submit">Logout</button>
</form>

<?php require_once app_path('includes/layout-footer.php'); ?>
