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
            $mail->Host       = $_ENV['SMTP_HOST'];                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_ENV['SMTP_USERNAME'];                 // SMTP username
            $mail->Password   = $_ENV['SMTP_PASSWORD'];                 // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $_ENV['SMTP_PORT'];                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Travel App');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendConfirmationEmail($email, $token): bool
    {
        $subject = "Confirm your email";
        $body = "<p>Click the link below to confirm your email</p>
                <a href='http://localhost:8000/confirm-email?token=$token'>Confirm Email</a>";

        return self::sendEmail($email, $subject, $body);
    }
}