<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelpers
{
    public static function sendEmail($email, $subject, $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = $_ENV['SMTP_HOST'];                     // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = $_ENV['SMTP_USERNAME'];                 // SMTP username
            $mail->Password = $_ENV['SMTP_PASSWORD'];                 // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = $_ENV['SMTP_PORT'];                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Travel App');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendConfirmationEmail($email, $token): bool
    {
        $subject = "Confirm your email";
        $body = "
                <p>Click the button below to confirm your email:</p>
                <form action='http://localhost/confirm-email' method='POST' style='display: inline;'>
                    <input type='hidden' name='token' value='$token'>
                    <button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Confirm Email</button>
                </form>
                ";


        return self::sendEmail($email, $subject, $body);
    }

    public static function sendBookingCanceledEmail($email, $bookingName): bool
    {
        $subject = "Booking Canceled";
        $body = "
        <p>Your booking for $bookingName has been cansceled</p>
       
                ";

        return self::sendEmail($email, $subject, $body);
    }

    public static function sendBookingConfirmedEmail($email, $bookingName): bool
    {
        $subject = "Booking Confirmed";
        $body = "
                <p>Your booking for $bookingName has been confirmed.</p>
                ";

        return self::sendEmail($email, $subject, $body);
    }

    public static function sendPasswordResetEmail($email, $token): bool
    {
        $resetUrl = "http://localhost/reset-password?token=$token&" . urlencode($email);
        $subject = "Reset your password";
        $body = "
                <p>Click the button below to reset your password:</p>
                <a href='$resetUrl' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none;'>Reset Password</a>
                ";

        return self::sendEmail($email, $subject, $body);
    }


}