<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Email verification link
$verification_link = "http://localhost/projects/Virtual-Queuing-System/verify_email.php?token=$verificationToken";

// Create instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->SMTPAuth   = true;
    $mail->Host       = 'mail.techgirlshub.co.za';
    $mail->Username   = 'nmlonzi@techgirlshub.co.za';
    $mail->Password   = 'Root96void23.';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Clear any previous recipients
    $mail->clearAddresses();

    // Send to user
    $mail->addAddress($email, $fullname);
    $mail->setFrom('no-reply@techgirlshub.co.za', 'Smart-Q Sys.');
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email Address - Smart-Q';

    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f3f3;
                margin: 0;
                padding: 20px;
            }
            .container {
                background-color: #ffffff;
                border-radius: 8px;
                max-width: 600px;
                margin: auto;
                padding: 30px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                color: #333;
            }
            .logo {
                text-align: center;
                margin-bottom: 20px;
            }
            .logo img {
                max-width: 120px;
                height: auto;
            }
            h2 {
                text-align: center;
                color: #444;
            }
            p {
                font-size: 15px;
                line-height: 1.6;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background-color:rgb(114, 148, 198);
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 20px;
            }
            .footer {
                margin-top: 30px;
                font-size: 14px;
                text-align: center;
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="https://nolwazi.techgirlshub.co.za/assets/queue.png" alt="Smart-Q Logo">
            </div>
            <h2>Welcome, '.$fullname.'!</h2>
            <p>Thank you for registering with <strong>Smart-Q</strong>. We are excited to have you onboard!</p>
            <p>Before you can start using your account, please verify your email address by clicking the button below:</p>
            <p style="text-align: center;">
                <a class="btn" href="'.$verification_link.'">Verify Email</a>
            </p>
            <p>If you did not create this account, please ignore this email.</p>
            <div class="footer">
                &copy; '.date('Y').' Smart-Q. All rights reserved.
            </div>
        </div>
    </body>
    </html>';

    $sendEmail = $mail->send();

    if ($sendEmail) {
        $message = "sent";
        // You may redirect or respond here
    } else {
        $message = "failed";
    }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
