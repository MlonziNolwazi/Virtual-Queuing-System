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
        $mail->setFrom('no-reply@techgirlshub.co.za', 'HeartLens App');
        $mail->addAddress($email, $firstname); // Send to the user's email

        // Set the subject
        $mail->Subject = 'Welcome to HeartLens App';

        // HTML email content
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
                    background-color: #e5d4b8ed;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    padding: 20px;
                    max-width: 600px;
                    margin: 0 auto;
                }
                .header {
                    background-color: #e09393;
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
        <body>
            <div class="container">
                <div class="header">
                    <h2>Welcome to HeartLens App</h2>
                </div>
                <div class="content">
                    <p>Hi ' . $firstname . ',</p>
                    <p>Thank you for creating an account with HeartLens App! We are thrilled to have you on board.</p>
                    <p>You can now log in to your account and explore all the features we have to offer. If you have any questions or need assistance, feel free to reach out to our support team.</p>
                    <p> One more step, please verify your email address by clicking the link below:</p>
                    <p>
                        <a href="'.$url.'/verify_user_email.php?code='. $verification_code .'" style="">
                            Verify Email
                        </a>
                    </p>
                    <p>Best regards,<br>HeartLens App Team</p>
                </div>
                <div class="footer">
                    <p>&copy; 2024 HeartLens App. All rights reserved.</p>
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
