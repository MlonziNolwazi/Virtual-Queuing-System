
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
        $mail->setFrom('testaccount1@techgirlshub.co.za', 'ManduloBooks Team');
        // HTML email content for the admin
        $mail->isHTML(true);

        $sendEmail = null;
    
        $mail->addAddress('testaccount1@techgirlshub.co.za'); // Add admin email

        // Set the email subject
        $mail->Subject = 'New Subscription Form Submission';

       
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #6c7f7d;
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
                    color: #e09393;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                                    <h2>New Newsletter Subscription</h2>
                                </div>
                                <div class="content">
                                    <p>Hello ManduloBooksGroup Team,</p>
                                    <p>You have received a new newsletter subscription request. Here are the details:</p>
                                    <p><strong>Email:</strong> ' . $email . '</p>
                                    <p>The subscriber has been added to your newsletter mailing list.</p>
                                    <p>Best regards,<br>ManduloBooksGroup Team</p>
                                </div>
                <div class="footer">
                    <p>&copy; 2024 ManduloBooksGroup App. All rights reserved.</p>
                    <p style="margin: 5px 0;"><a href="'.$url.'/../index.php" style="color: #0073e6; text-decoration: none;">Visit ManduloBooksGroup App</a></p>
                </div>
            </div>
        </body>
        </html>
        ';

        $sendEmail = $mail->send();
    
        

        if ($sendEmail) {
            // Now send a no-reply email to the user
            $mail->clearAddresses(); // Clear the previous recipient

            $mail->addAddress($email, $fullname); // Add the user's email
        
            // Set the subject for the user email
            $mail->Subject = 'Thank You for Subscribing to Our Newsletter';
            $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #6c7f7d;
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
                        color: #e09393;
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                                    <div class="header">
                                        <h2>Welcome to Our Newsletter!</h2>
                                    </div>
                                    <div class="content">
                                        <p>Dear ' . $fullname . ',</p>
                                        <p>Thank you for subscribing to our newsletter! We are excited to have you join our community.</p>
                                        <p>You will receive updates about our latest features and use of app tips.</p>
                                        <p>Best regards,<br>Mandulo Books Group Team</p>
                                    </div>
                    <div class="footer">
                        <p>&copy; 2024 ManduloBooksGroup App. All rights reserved.</p>
                        <p style="margin: 5px 0;"><a href="'.$url.'/../index.php" style="color: #0073e6; text-decoration: none;">Visit ManduloBooksGroup App</a></p>
                    </div>
                </div>
            </body>
            </html>
            ';

            // Send the no-reply email to the user
            $mail->setFrom('no-reply@techgirlshub.co.za', 'ManduloBooks Team'); // Set no-reply address
            $sendEmail = $mail->send();
        }

        
          if ($sendEmail) {
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
