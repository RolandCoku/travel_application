<?php
$title = 'Elite Travel | Reset Password';
$cssFile = 'user/reset_password.css?=v' . time();
require_once app_path('includes/layout-header.php');
?>

<body class="reset-password-page">

<div class="logo-container">
    <div class="image-container">
        <img class="login-image" src="/img/assets/logo-2.png" alt="Logo 2">
        <img class="login-image" src="/img/assets/logo-1.png" alt="Logo 1">
    </div>
</div>

<main class="reset-password-container">
    <form class="reset-password-form" action="/reset-password" method="post">
        <h1 class="form-title">Reset Password</h1>
        <?php if (isset($_SESSION['reset']['error'])): ?>
            <p class="error-message"><?= $_SESSION['reset']['error'] ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['reset']['success'])): ?>
            <p class="success-message"><?= $_SESSION['reset']['success'] ?></p>
        <?php endif; ?>
        <div class="input-group">
            <label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </label>
            <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-group">
            <label>
                <input type="password" name="new_password" placeholder="New Password" required>
            </label>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-group">
            <label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </label>
            <i class='bx bxs-lock'></i>
        </div>
        <button type="submit" class="btn-primary">Reset Password</button>
        <div class="login-link">
            <p>Remembered your password? <a href="/login">Login now</a></p>
        </div>
    </form>
</main>

<?php require_once app_path('includes/layout-footer.php'); ?>
