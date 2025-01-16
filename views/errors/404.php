<?php
$title = 'Not Found';
$cssFile = '404.css';
require_once app_path('includes/layout-header.php');
?>

<div class="container">
    <div class="error">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>Sorry, the page you are looking for could not be found.</p>
        <a href="/">Go to Home</a>
    </div>
</div>

<?php
require_once app_path('includes/layout-footer.php');
?>
