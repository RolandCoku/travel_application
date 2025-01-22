<?php
$title = 'Elite Travel | Login';
$cssFiles = [
    'user/login.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body class="login-page">

<div class="logo-container">
    <div class="image-container">
        <img class="login-image" src="/img/assets/logo-2.png" alt="Logo 2">
        <img class="login-image" src="/img/assets/logo-1.png" alt="Logo 1">
    </div>
</div>

<main class="login-container">
    <form class="login-form" action="/login" method="post">
        <h1 class="form-title">Login</h1>
        <?php if (isset($_SESSION['login']['error'])): ?>
            <p class="error-message"><?= $_SESSION['login']['error'] ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['register']['success'])): ?>
            <p class="success-message"><?= $_SESSION['register']['success'] ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['login']['success'])): ?>
            <p class="success-message"><?= $_SESSION['login']['success'] ?></p>
        <?php endif; ?>
        <div class="input-group">
            <label>
                <input type="email" name="email" placeholder="Email" required>
            </label>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-group">
            <label>
                <input type="password" name="password" placeholder="Password" required>
            </label>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="form-options">
            <label class="remember-me">
                <input type="checkbox" name="remember-me"> Remember me</label>
            <a href="/forgot-password">Forgot Password?</a>
        </div>
        <button type="submit" class="btn-primary">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="/register">Register now</a></p>
        </div>
    </form>
</main>

<?php require_once app_path('includes/layout-footer.php'); ?>
