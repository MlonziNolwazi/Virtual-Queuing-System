<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Documentation - Smart-Q</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .doc-container {
      max-width: 960px;
      margin: auto;
      padding: 20px;
      background: #fff;
    }
    h1, h5, h3 {
      color: #2c3e50;
    }
    p, .doc-container li {
      color: #333;
      line-height: 1.6;
    }
    ul {
      padding-left: 20px;
    }
    @media (max-width: 600px) {
      .doc-container {
        padding: 10px;
      }
    }
  </style>
    <?php include 'php/config/base_config.php'; ?>
    <base href="<?php echo $baseUrl; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div style="background-color:rgb(7, 8, 8);">
     <?php include 'header.php'; ?>
</div>
  <div class="doc-container">
    <h1>User Documentation - Smart-Q</h1>

    <h5>1. Getting Started</h5>
    <p>Welcome to the Smart-Q! This guide will walk you through the process of using the platform effectively.</p>

    <h5>2. User Registration</h5>
    <ul>
      <li>Click on the <strong>Register</strong> button on the homepage.</li>
      <li>Enter your name, email, and create a password.</li>
      <li>Confirm your email if required.</li>
      <li>Log in using your credentials.</li>
    </ul>

    <h5>3. Booking an Appointment</h5>
    <ul>
      <li>Once logged in, select a service provider (e.g., a bank or clinic).</li>
      <li>View available services and select one.</li>
      <li>Choose a date and time slot from the calendar.</li>
      <li>Fill in any required custom fields (e.g., ID number, reason for visit).</li>
      <li>Click <strong>Book Appointment</strong>.</li>
    </ul>

    <h5>4. Managing Appointments</h5>
    <ul>
      <li>Go to <strong>My Appointments</strong> to see upcoming bookings.</li>
      <li>You can <strong>reschedule</strong> or <strong>cancel</strong> appointments if needed.</li>
    </ul>

    <h5>5. Tracking the Queue</h5>
    <ul>
      <li>Visit the <strong>Queue Tracker</strong> section.</li>
      <li>Monitor your queue number and estimated wait time in real-time.</li>
      <li>You’ll receive alerts when you’re near the front of the queue.</li>
    </ul>

    <h5>6. Notifications</h5>
    <ul>
      <li>Ensure notifications are enabled to receive booking confirmations and queue updates.</li>
      <li>Notifications can be received via SMS, email, or push (if supported).</li>
    </ul>

    <h5>7. Frequently Asked Questions (FAQs)</h5>
    <ul>
      <li><strong>Can I book multiple appointments?</strong> — Yes, but not at the same time slot.</li>
      <li><strong>What happens if I miss my slot?</strong> — Your queue number will be forfeited after a grace period.</li>
      <li><strong>Can I update my contact info?</strong> — Yes, under <strong>Account Settings</strong>.</li>
    </ul>

    <h5>8. Support</h5>
    <p>If you encounter issues, contact support at <a href="mailto:nolwazi@techgirlshub.co.za">nolwazi@techgirlshub.co.za</a>.</p>

    <p>Thank you for using the Smart-Q!</p>
  </div>
  <?php include 'footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
