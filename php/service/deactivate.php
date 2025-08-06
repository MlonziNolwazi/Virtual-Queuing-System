<?php
session_start();
require '../config/config.php'; // your DB connection file

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
    exit;
}

// Get the raw input
$input = json_decode(file_get_contents('php://input'), true);

if ($input && isset($input['deactivate']) && $input['deactivate'] === true) {
    $user_id = $_SESSION['user_id'];

    // Option 1: Soft delete (deactivation flag)
    $stmt = $connect->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Optional: destroy session immediately
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Account deactivated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to deactivate account.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
