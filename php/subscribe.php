<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/config.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['subscribe_email']), FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo "Invalid email address.";
        exit;
    }

    // Check for duplicates
    $check = $connect->prepare("SELECT id FROM subscribers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "You are already subscribed.";
        exit;
    }

    // Insert into DB
    $insert = $connect->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $insert->bind_param("s", $email);

    if ($insert->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->Host       = 'mail.techgirlshub.co.za';
            $mail->Username   = 'nmlonzi@techgirlshub.co.za';
            $mail->Password   = 'Root96void23.';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('nmlonzi@techgirlshub.co.za', 'Smart-Q');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';  // Add this line
            $mail->Subject = '🎉 Welcome to Smart-Q Updates!';


            $mail->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; background-color: #fefefe;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="https://nolwazi.techgirlshub.co.za/assets/queue.png" alt="TechGirlsHub Logo" style="width: 150px;">
                    </div>
                    <h2 style="color: #444;">Thank You for Subscribing!</h2>
                    <p style="font-size: 16px; color: #333;">
                        Hello there 👋,<br><br>
                        You have successfully subscribed to <strong>Smart-Q</strong> updates.<br>
                        We’re excited to have you on board and can’t wait to keep you updated with our latest news, tips, and improvements.
                    </p>
                    <p style="font-size: 16px; color: #333;">
                        ✨ Stay tuned for updates about smarter ways to manage your appointments and wait times!
                    </p>
                    <hr style="margin: 30px 0;">
                    <p style="font-size: 14px; color: #777;">
                        If you didn’t subscribe, please ignore this email or contact us at 
                        <a href="mailto:nmlonzi@techgirlshub.co.za" style="color: #3366cc;">nmlonzi@techgirlshub.co.za</a>.
                    </p>
                    <div style="text-align: center; font-size: 13px; color: #aaa; margin-top: 20px;">
                        &copy; ' . date("Y") . ' TechGirlsHub | Smart-Q
                    </div>
                </div>
            ';

            $mail->send();
            echo "success";
        } catch (Exception $e) {
            echo "Subscribed, but confirmation email failed.";
        }
    } else {
        echo "Something went wrong. Try again.";
    }

    $check->close();
    $insert->close();
    $connect->close();
}
?>
