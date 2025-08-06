
<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'mail.techgirlshub.co.za';
        $mail->Username   = 'testaccount1@techgirlshub.co.za';
        $mail->Password   = 'TestAccount1';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        // Email to admin
        $mail->setFrom('no-reply@techgirlshub.co.za', 'HeartLens App Team'); // Set no-reply address
        $mail->addAddress($email); // Add admin email

        // Set the email subject
        $mail->Subject = 'Password Reset Link';

        // HTML email content for the admin
        $mail->isHTML(true);
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    background-color: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    padding: 20px;
                    max-width: 600px;
                    margin: 0 auto;
                }
                .header {
                    background-color: #007bff;
                    color: white;
                    padding: 10px;
                    text-align: center;
                    border-radius: 8px 8px 0 0;
                }
                .content {
                    padding: 20px;
                    font-size: 16px;
                    line-height: 1.5;
                    color: #333;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    color: #999;
                    font-size: 14px;
                }
                .footer a {
                    color: #007bff;
                    text-decoration: none;
                }
            </style>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #6c7f7d;  margin: 0; padding: 0;">
        <div class="container" style="max-width: 600px; margin: 20px auto; background-color: #e5d4b8ed; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <!-- Header Section -->
            <div class="header" style="background-color: #e09393; color: #ffffff; margin: 0; padding: 20px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                <h2 style="margin: 0; font-size: 24px;">Password Reset Request</h2>
            </div>

            <!-- Content Section -->
            <div class="content" style="padding: 20px; line-height: 1.6; color: #333333;">
                <p style="margin: 0;">Hello,</p>
                <p style="margin-top: 10px;">We received a request to reset the password for your account. If you made this request, please use the link below to reset your password:</p>
                <p>
                    <a href="'.$resetLink.'" style="font-size: 14px !important;">'.$resetLink.'</a>
                </p>
                <p style="margin-top: 20px;">If you did not request a password reset, please ignore this email or contact our support team for assistance.</p>
                <p style="margin-top: 20px;">For your security, this link will expire in 1 hour.</p>
                <p style="margin-top: 20px;">Best regards,</p>
                <p style="margin: 0;">HeartLens App Team</p>
            </div>

            <!-- Footer Section -->
            <div class="footer" style="background-color: #f9f9f9; color: #555555; padding: 10px 20px; text-align: center; font-size: 14px; border-top: 1px solid #dddddd;">
                <p style="margin: 0;">&copy; 2024 HeartLens App. All rights reserved.</p>
                <p style="margin: 5px 0;"><a href="'.$url.'/../index.html" style="color: #0073e6; text-decoration: none;">Visit HeartLens App</a></p>
            </div>
        </div>
    </body>

        </html>
        ';
   
        if ($mail->send()) {
            $message = "sent";
            //header("Location: {$_SERVER['HTTP_REFERER']}");
            //exit(0);
        } else {
            $message = "failed";
        }
      
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
