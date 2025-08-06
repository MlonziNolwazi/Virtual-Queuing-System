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
    $mail->setFrom('testaccount1@techgirlshub.co.za', 'Mandulo Books Group');
    $mail->addAddress('testaccount1@techgirlshub.co.za'); // Admin email

    // HTML email content for the admin
    $mail->isHTML(true);
    $mail->Subject = 'New Payment Transaction Notification';
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
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
                background-color: #4CAF50;
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
                color: #4CAF50;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>New Payment Received</h2>
            </div>
            <div class="content">
                <p>Hello Mandulo Books Group Team,</p>
                <p>You have received a new payment. Here are the details:</p>
                <ul>
                    <li><strong>Transaction ID:</strong> ' . $transactionID . '</li>
                    <li><strong>Amount:</strong> $' . $paymentAmount . '</li>
                    <li><strong>Date:</strong> ' . $paymentDate . '</li>
                    <li><strong>Customer Name:</strong> ' . $fullname . '</li>
                    <li><strong>Customer Email:</strong> ' . $email . '</li>
                </ul>
                <p>Best regards,<br>Mandulo Books Group Team</p>
            </div>
            <div class="footer">
                <p>&copy; 2024 Mandulo Books Group. All rights reserved.</p>
                <p><a href="' . $url . '/../index.php">Visit Mandulo Books Group</a></p>
            </div>
        </div>
    </body>
    </html>
    ';

    $sendEmail = $mail->send();

    if ($sendEmail) {
        // Send a receipt email to the customer
        $mail->clearAddresses(); // Clear previous recipients
        $mail->addAddress($email, $fullname); // Customer email

        // Set the subject and content for the customer email
        $mail->Subject = 'Payment Receipt - Mandulo Books Group';
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
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
                    background-color: #4CAF50;
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
                    color: #4CAF50;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Payment Receipt</h2>
                </div>
                <div class="content">
                    <p>Dear ' . $fullname . ',</p>
                    <p>Thank you for your payment. Here are your transaction details:</p>
                    <div style="border: 1px solid #ddd; padding: 20px; margin: 20px 0;">
                        <h3 style="color: #4CAF50; margin-bottom: 15px;">INVOICE (PAID)</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 8px;"><strong>Transaction ID:</strong></td>
                                <td style="padding: 8px;">' . $transactionID . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 8px;"><strong>Amount Paid:</strong></td>
                                <td style="padding: 8px;">R' . $paymentAmount . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 8px;"><strong>Payment Date:</strong></td>
                                <td style="padding: 8px;">' . $paymentDate . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 8px;"><strong>Items Purchased:</strong></td>
                                <td style="padding: 8px;">
                                    <ul style="margin: 0; padding-left: 20px;">
                                        ' . implode('', array_map(function($item) {
                                            return '<li>' . trim($item) . '</li>';
                                        }, explode(',', $items))) . '
                                    </ul>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 8px;"><strong>Payment Status:</strong></td>
                                <td style="padding: 8px; color: #4CAF50;">PAID</td>
                            </tr>
                        </table>
                        <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                            <h4 style="color: #4CAF50; margin-bottom: 10px;">Next Steps:</h4>
                            <p>Your order is now being processed and will be shipped within 2-3 business days.</p>
                            <p>To track your order, please:</p>
                            <ol style="margin: 10px 0; padding-left: 25px;">
                                <li>Visit our order tracking page at <a href="' . $url . '/../track_order.php" style="color: #4CAF50;">Track Your Order</a></li>
                                <li>Enter your Transaction ID: ' . $transactionID . '</li>
                                <li>Click "Track Order" to see your order status</li>
                            </ol>
                            <p style="margin-top: 10px; font-size: 14px; color: #666;">For any questions about your order, please contact our customer support at support@mandulobooksgroup.co.za</p>
                        </div>
                    </div>
                    <p>We appreciate your support!</p>
                    <p>Best regards,<br>Mandulo Books Group Team</p>
                </div>
                <div class="footer">
                    <p>&copy; 2024 Mandulo Books Group. All rights reserved.</p>
                    <p><a href="' . $url . '/../index.php">Visit Mandulo Books Group</a></p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Send the receipt email
        $sendEmail = $mail->send();
    }

    if ($sendEmail) {
        $message = "sent";
    } else {
        $message = "failed";
    }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
