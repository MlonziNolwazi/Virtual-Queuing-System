<?php
// filepath: c:\xampp\htdocs\projects\Virtual-Queuing-System\send_reset_email.php
require_once 'php/PHPMailer/src/Exception.php';
require_once 'php/PHPMailer/src/PHPMailer.php';
require_once 'php/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'php/config/config.php'; // This should contain mysqli connection as $connect
include 'php/config/base_config.php'; // must contain $baseUrl

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    // 1. Check if email exists in users table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // 2. Check if user exists and provide appropriate response
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Delete previous tokens
        $deleteSql = "DELETE FROM password_resets WHERE email = ?";
        $deleteStmt = mysqli_prepare($connect, $deleteSql);
        mysqli_stmt_bind_param($deleteStmt, "s", $email);
        mysqli_stmt_execute($deleteStmt);
        mysqli_stmt_close($deleteStmt);

        // Insert new token
        $insertSql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $insertStmt = mysqli_prepare($connect, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "sss", $email, $token, $expiresAt);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);

        // 3. Build reset link
        $resetLink = $baseUrl . "reset_password.php?token=" . $token;

        // 4. Send password reset email
        $emailSent = sendPasswordResetEmail($email, $user['full_name'], $resetLink, $token);
        
        if (!$emailSent) {
            error_log("Failed to send password reset email to: " . $email);
            echo "<script>
                    alert('Failed to send reset email. Please try again later.');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Reset link has been sent to your email.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        // Email not found
        echo "<script>
                alert('Email address not found. Please check your email and try again.');
                window.location.href = 'login.php';
              </script>";
    }

    mysqli_stmt_close($stmt);
}

/**
 * Send password reset email
 */
function sendPasswordResetEmail($toEmail, $userName, $resetLink, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings - UPDATE THESE WITH YOUR SMTP DETAILS
        $mail->isSMTP();
        $mail->Host       = 'mail.techgirlshub.co.za'; // Change to your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nmlonzi@techgirlshub.co.za'; // Your email address
        $mail->Password   = 'Root96void23.'; // Your email password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('nmlonzi@techgirlshub.co.za', 'Smart-Q'); 
        $mail->addAddress($toEmail, $userName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request - Smart-Q';
        
        $mail->Body = getEmailTemplate($userName, $resetLink, $token);

        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Professional email template for password reset
 */
function getEmailTemplate($userName, $resetLink, $token) {
    return "
    <html>
    <head>
        <title>Password Reset - Smart-Q</title>
        <style>
            body { 
                font-family: 'Arial', 'Helvetica', sans-serif; 
                background-color: #f5f5f5;
                color: #333333; 
                line-height: 1.6;
                margin: 0;
                padding: 20px;
            }
            .container { 
                max-width: 600px; 
                margin: 0 auto; 
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            .header { 
                background: #007bff;
                text-align: center; 
                padding: 30px 20px;
                color: white;
            }
            .logo {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .content { 
                padding: 40px 30px;
            }
            .greeting {
                font-size: 18px;
                margin-bottom: 20px;
                color: #333;
            }
            .message-text {
                font-size: 16px;
                margin-bottom: 15px;
                color: #555;
            }
            .reset-btn { 
                background: #007bff;
                color: white !important; 
                padding: 15px 30px; 
                text-decoration: none; 
                border-radius: 5px; 
                display: inline-block; 
                margin: 25px 0;
                font-size: 16px;
                font-weight: bold;
            }
            .reset-btn:hover {
                background: #0056b3;
            }
            .warning {
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                border-radius: 5px;
                padding: 15px;
                margin: 20px 0;
                color: #856404;
            }
            .footer { 
                text-align: center; 
                padding: 30px 20px;
                background: #f8f9fa;
                color: #666;
                border-top: 1px solid #e9ecef;
            }
            .footer a {
                color: #007bff;
                text-decoration: none;
                word-break: break-all;
            }
            .divider {
                height: 1px;
                background: #e9ecef;
                margin: 25px 0;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <div class='logo'>Smart-Q</div>
                <p>Password Reset Request</p>
            </div>
            
            <div class='content'>
                <div class='greeting'>
                    Hello " . htmlspecialchars($userName) . ",
                </div>
                
                <div class='message-text'>
                    We received a request to reset the password for your Smart-Q account.
                </div>
                
                <div class='message-text'>
                    To reset your password, please click the button below:
                </div>
                
                <div style='text-align: center;'>
                    <a href='{$resetLink}' class='reset-btn'>Reset Password</a>
                </div>
                
                <div class='warning'>
                    <strong>Important:</strong> This link will expire in <strong>30 minutes</strong> for security reasons. 
                    If you need to reset your password after this time, please request a new reset link.
                </div>
                
                <div class='message-text'>
                    If you did not request a password reset, please ignore this email. Your account remains secure.
                </div>
                
                <div class='divider'></div>
                
                <div class='message-text'>
                    If you're having trouble clicking the button, you can copy and paste the following link into your browser:
                </div>
                <p style='word-break: break-all; color: #007bff;'>{$resetLink}</p>
            </div>
            
            <div class='footer'>
                <p><strong>Smart-Q</strong></p>
                <p>This is an automated message, please do not reply to this email.</p>
                
                <p style='margin-top: 20px; font-size: 12px; color: #888;'>
                    Token: {$token} | Expires: " . date('Y-m-d H:i:s', strtotime('+30 minutes')) . "
                </p>
            </div>
        </div>
    </body>
    </html>
    ";
}
?>
