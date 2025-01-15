<?php
$title = 'Elite Travel - Register';
$cssFile = 'user/register.css';
require_once app_path('includes/layout-header.php'); ?>

    <body class="register-page">
    <div class="container">
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
                <!-- Surname -->
                <div class="input-group">
                    <label for="surname">
                        <input type="text" name="surname" id="surname" placeholder="Surname" required>
                    </label>
                    <i class='bx bxs-user'></i>
                </div>
                <!-- Email -->
                <div class="input-group">
                    <label for="email">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </label>
                    <i class='bx bxs-envelope'></i>
                </div>
                <!-- Password -->
                <div class="input-group">
                    <label for="password">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="confirm_password">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    </label>
                    <i class='bx bxs-lock'></i>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn-primary">Register</button>
                <div class="login-link">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>
            </form>
        </main>
    </div>

<?php require_once app_path('includes/layout-footer.php'); ?>