<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <title>Elite Travel - Login</title>-->
<!--    <link rel="stylesheet" href="--><?php //= base_url("views/user/travel-package/style.css"); ?><!--">-->
<!--    <link href="--><?php //= base_url("/css/boxicons-2.1.4/css/boxicons.min.css"); ?><!--" rel="stylesheet">-->
<!--</head>-->
<!--<body>-->


<?php
$title = 'Elite Travel - Login';
require_once app_path('includes/layout-header.php');
?>

<!--<header class="header">-->
<!--    <div class="container">-->
<!--        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTdWIhweoIGz48FgJ8J_0nf8bdpnm8w06rZgg&s" width="250px" alt="logo">-->
<!--    </div>-->
<!--</header>-->

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
            <p>Don't have an account? <a href="#">Register now</a></p>
        </div>
    </form>
</main>

<?php require_once app_path('includes/layout-footer.php'); ?>
