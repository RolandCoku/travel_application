<?php
$title = 'Elite Travel - Reset Password Email Sent';
$cssFile = 'user/reset-password-email-sent.css?=v' . time();
require_once app_path('includes/layout-header.php'); ?>

<body class="reset-password-email-page">
<div class="confirmation-container">
    <div class="confirmation-box">
        <h1>Reset Password Email Sent</h1>
        <p>We have sent a password reset link to your email <?php if (isset($email)) echo $email ?>.</p>
        <p>Please check your inbox and follow the instructions to reset your password.</p>
        <p>If you didn’t receive the email, check your spam folder or <a href="/resend-reset-email" class="resend-link">resend the reset email</a>.</p>
    </div>
</div>
</body>

<?php require_once app_path('includes/layout-footer.php'); ?>

