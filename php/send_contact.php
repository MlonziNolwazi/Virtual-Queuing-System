<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<script>
          alert('Please fill in all fields.');
          window.history.back();
        </script>";
        exit;
    }

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

        // Recipients
        $mail->setFrom('nmlonzi@techgirlshub.co.za', 'Website Contact Form');
        $mail->addAddress('nmlonzi@techgirlshub.co.za'); // Where you want to receive the contact messages

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Contact Form: $subject";
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
            <div style='text-align: center; margin-bottom: 20px;'>
              <img src='https://nolwazi.techgirlshub.co.za/assets/queue.png' alt='Logo' style='max-width: 150px; height: auto;'>
            </div>
            <h2 style='background-color: #f4f4f4; padding: 10px; border-bottom: 2px solid #ddd;'>New Contact Message</h2>
            <p><strong>Name:</strong> <span style='color: #0056b3;'>{$name}</span></p>
            <p><strong>Email:</strong> <span style='color: #0056b3;'>{$email}</span></p>
            <p><strong>Subject:</strong> <span style='color: #0056b3;'>{$subject}</span></p>
            <p><strong>Message:</strong><br><div style='padding: 10px; border: 1px solid #eee;'>{$message}</div></p>
            <p style='font-size: 0.8em; color: #777;'>This message was sent via the contact form on your website.</p>
            </div>
          ";

        $mail->send();

        echo "<script>
          alert('Message sent successfully!');
          window.location.href = '../index.php';
        </script>";
          } catch (Exception $e) {
        echo "<script>
          alert('Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "');
          window.history.back();
        </script>";
        }
    
} else {
    header("Location: contact.html");
    exit;
}
