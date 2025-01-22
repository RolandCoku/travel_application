<?php
$title = 'Elite Travel - Email Confirmation';
$cssFiles = [
    'user/email-confirmation.css?=v' . time()
];
require_once app_path('includes/layout-header.php'); ?>

    <body class="email-confirmation-page">
    <div class="confirmation-container">
        <div class="confirmation-box">
            <h1>Email Confirmation</h1>
            <p>We've sent a confirmation link to your email <?php if (isset($email)) echo $email ?>.</p>
            <p>Please check your inbox and follow the instructions to verify your account.</p>
            <p>If you didn't receive the email, check your spam folder or <a href="/resend-email" class="resend-link">resend the confirmation email</a>.</p>
        </div>
    </div>
    </body>

<?php require_once app_path('includes/layout-footer.php'); ?>