<?php
$title = 'Not Found';
$cssFiles = [
    'errors/404.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<div class="error-container">
    <div class="error-content">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>Sorry, the page you are looking for could not be found.</p>
        <a href="/" class="btn btn-primary">Go to Home</a>
    </div>
</div>

<?php
require_once app_path('includes/layout-footer.php');
?>
