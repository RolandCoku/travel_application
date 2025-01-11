<?php
$title = 'Elite Travel - Login';
$cssFile = 'user/login.css';
require_once app_path('includes/layout-header.php');
?>

<body class="login-page">
<main class="login-container">
    <form class="login-form" action="/login" method="post">
        <h1 class="form-title">Login</h1>
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
            <label><input type="checkbox"> Remember me</label>
            <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="btn-primary">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="/register">Register now</a></p>
        </div>
    </form>
</main>

<?php require_once app_path('includes/layout-footer.php'); ?>
