<?php
session_start();
require 'config/config.php';

ini_set('display_errors', 1); // Enable for debugging
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Sanitize and retrieve form inputs
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$user_type = isset($_POST['user_type']) ? trim($_POST['user_type']) : '';
$password = $_POST['password']; // can be empty

// Fetch current user data
$query = $connect->prepare("SELECT profile_picture, password_hash FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

$current_picture = $user['profile_picture'];
$current_password = $user['password_hash'];

// Handle profile picture upload
$new_picture_name = $current_picture;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

        // Delete previous profile picture if it's not empty and exists
    if (!empty($current_picture)) {
        $old_picture_path = $upload_dir . $current_picture;
        if (file_exists($old_picture_path)) {
            unlink($old_picture_path);
        }
    }

    $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
    $new_picture_name = 'profile_' . $user_id . '.' . strtolower($ext);
    $destination = $upload_dir . $new_picture_name;

    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination);
}

// Handle password
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
} else {
    $hashed_password = $current_password;
}

// Update database
if (!empty($user_type)) {
    $update = $connect->prepare("UPDATE users SET full_name = ?, email = ?, password_hash = ?, user_type = ?, profile_picture = ? WHERE id = ?");
    $update->bind_param("sssssi", $full_name, $email, $hashed_password, $user_type, $new_picture_name, $user_id);
} else {
    $update = $connect->prepare("UPDATE users SET full_name = ?, email = ?, password_hash = ?, profile_picture = ? WHERE id = ?");
    $update->bind_param("ssssi", $full_name, $email, $hashed_password, $new_picture_name, $user_id);
}

if ($update->execute()) {
    // Update session values
    $_SESSION['username'] = $full_name;
    if (!empty($user_type)) {
        $_SESSION['user_type'] = $user_type;
        $_SESSION['role'] = $user_type; // Ensure role is set in session
    }
    $_SESSION['user_email'] = $email;
    $_SESSION['user_picture'] = $new_picture_name;
    $_SESSION['profile_picture'] = $new_picture_name;
   

    // Return updated user details
    $updated_user = [
        'full_name' => $full_name,
        'email' => $email,
        'user_type' => $user_type,
        'profile_picture' => $new_picture_name,
        'user_id' => $user_id,
        'role' => $_SESSION['role'] ?? 'client' // Default to 'client'
    ];
    echo json_encode(["status" => "success", "message" => "Profile updated successfully", "user" => $updated_user]);
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "Database update failed: " . $connect->error]);
    exit;
}
?>
