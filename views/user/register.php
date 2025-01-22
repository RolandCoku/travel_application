<?php
$title = 'Elite Travel - Register';
$cssFiles = [
    'user/register.css?=v' . time()
];
require_once app_path('includes/layout-header.php'); ?>

    <body class="register-page">
    <div class="logo-container">
        <div class="image-container">
            <img class="login-image" src="/img/assets/logo-2.png" alt="Logo 2">
            <img class="login-image" src="/img/assets/logo-1.png" alt="Logo 1">
        </div>
    </div>
    <main class="register-container">
        <form action="/register" method="post" class="register-form">
            <h1 class="form-title">Register</h1>
            <!-- Name -->
            <div class="input-group">
                <label for="name">
                    <input type="text" name="name" id="name" placeholder="Name" required>
                </label>
                <i class='bx bxs-user'></i>
            </div>
            <?php if (isset($_SESSION['register']['name_error'])): ?>
                <p class="error-message"><?= $_SESSION['register']['name_error'] ?></p>
            <?php endif; ?>
            <!-- Surname -->
            <div class="input-group">
                <label for="surname">
                    <input type="text" name="surname" id="surname" placeholder="Surname" required>
                </label>
                <i class='bx bxs-user'></i>
            </div>
            <?php if (isset($_SESSION['register']['surname_error'])): ?>
                <p class="error-message"><?= $_SESSION['register']['surname_error'] ?></p>
            <?php endif; ?>
            <!-- Email -->
            <div class="input-group">
                <label for="email">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </label>
                <i class='bx bxs-envelope'></i>
            </div>
            <?php if (isset($_SESSION['register']['email_error'])): ?>
                <p class="error-message"><?= $_SESSION['register']['email_error'] ?></p>
            <?php endif; ?>
            <!-- Password -->
            <div class="input-group">
                <label for="password">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </label>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <?php if (isset($_SESSION['register']['password_error'])): ?>
                <div class="error-message"><?= $_SESSION['register']['password_error'] ?></div>
            <?php endif; ?>
            <!-- Confirm Password -->
            <div class="input-group">
                <label for="confirm_password">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                </label>
                <i class='bx bxs-lock'></i>
            </div>
            <?php if (isset($_SESSION['register']['confirm_password_error'])): ?>
                <div class="error-message"><?= $_SESSION['register']['confirm_password_error'] ?></div>
            <?php endif; ?>
            <!-- Submit Button -->
            <?php if (isset($_SESSION['register']['error'])): ?>
                <p class="error-message"><?= $_SESSION['register']['error'] ?></p>
            <?php endif; ?>
            <button type="submit" class="btn-primary">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="/login">Login here</a></p>
            </div>
        </form>
    </main>

<?php
$jsFile = 'user/register.js?=v' . time();
require_once app_path('includes/layout-footer.php');
?>