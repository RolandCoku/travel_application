<?php
$title = 'Elite Travel | Forgot Password';
$cssFile = 'user/forgot_password.css?=v' . time();
require_once app_path('includes/layout-header.php');
?>

<body class="forgot-password-page">

<div class="logo-container">
    <div class="image-container">
        <img class="login-image" src="/img/assets/logo-2.png" alt="Logo 2">
        <img class="login-image" src="/img/assets/logo-1.png" alt="Logo 1">
    </div>
</div>

<main class="forgot-password-container">
    <form class="forgot-password-form" action="/forgot-password" method="post">
        <h1 class="form-title">Forgot Password</h1>
        <?php if (isset($_SESSION['forgot-password']['error'])): ?>
            <p class="error-message"><?= $_SESSION['forgot-password']['error'] ?></p>
        <?php endif; ?>
        <div class="input-group">
            <label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </label>
            <i class='bx bxs-envelope'></i>
        </div>
        <button type="submit" class="btn-primary">Send Reset Link</button>
        <div class="login-link">
            <p>Remembered your password? <a href="/login">Login now</a></p>
        </div>
    </form>
</main>

<?php require_once app_path('includes/layout-footer.php'); ?>


