<?php
include 'php/config/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $connect->prepare("SELECT * FROM users WHERE email_verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $stmt = $connect->prepare("UPDATE users SET is_verified = 1, email_verification_token = NULL WHERE email_verification_token = ?");
        $stmt->bind_param("s", $token);
        if ($stmt->execute()) {
            echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verified</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .message-box {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }
    .message-box h2 {
      color: #2e7d32;
      margin-bottom: 15px;
    }
    .message-box p {
      color: #555;
      font-size: 16px;
      margin-bottom: 25px;
    }
    .message-box a {
      text-decoration: none;
      background-color: #2e7d32;
      color: #fff;
      padding: 12px 25px;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .message-box a:hover {
      background-color: #1b5e20;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2>✅ Email Verified</h2>
    <p>Your email has been successfully verified. You can now log in to your account.</p>
    <a href="login.php">Go to Login</a>
  </div>
</body>
</html>';
        } else {
            echo "Verification failed. Please try again.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>
