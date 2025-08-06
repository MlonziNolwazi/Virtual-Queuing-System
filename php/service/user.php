<?php
session_start(); // Start session to enable $_SESSION variables

require_once(__DIR__ . '/../config/config.php');
/**
 * Encrypts a password using PHP's password_hash function.
 *
 * @param string $password The plain-text password to encrypt.
 * @return string The hashed password.
 */
function encryptPassword($password) {
    // Use PASSWORD_DEFAULT to ensure the best hashing algorithm available in PHP.
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Creates a new user account in the database with the provided form data.
 * Encrypts the password and inserts user details into the users table.
 */
function createUser() {
    
    global $connect, $data;
    $message = null;
    $fullname = isset($_POST['data']['fullname']) ? $_POST['data']['fullname'] : null;
    $userType = isset($_POST['data']['userType']) ? $_POST['data']['userType'] : null;
    $email = isset($_POST['data']['email']) ? $_POST['data']['email'] : null;
    $password = isset($_POST['data']['password']) ? encryptPassword($_POST['data']['password']) : null;
    require_once(__DIR__ . '/../config/base_config.php');
    $url = $config['base_url'] ?? null;
    $verificationToken = bin2hex(random_bytes(32));

    // Check if user with this email exists but is deactivated
    $sql_check = "SELECT id FROM users WHERE email = ? AND is_active = 0";
    $stmt_check = mysqli_prepare($connect, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if ($existing = mysqli_fetch_assoc($result_check)) {
        // Reactivate account instead of creating new one
        $sql_reactivate = "UPDATE users SET full_name = ?, password_hash = ?, user_type = ?, email_verification_token = ?, is_active = 1, is_verified = 0 WHERE email = ?";
        $stmt_reactivate = mysqli_prepare($connect, $sql_reactivate);
        mysqli_stmt_bind_param($stmt_reactivate, "sssss", $fullname, $password, $userType, $verificationToken, $email);

        if (mysqli_stmt_execute($stmt_reactivate)) {
            require(__DIR__ . "/../emails/confirm-email.php");
            if($message && $message === 'sent') {
                echo json_encode(['message' => 'Account reactivated. Please verify via email.', 'isCreated' => true, 'data' => $data]);
            } else {
                echo json_encode(['message' => 'Reactivated but failed to send email.', 'isCreated' => false]);
            }
        } else {
            echo json_encode(['message' => 'Failed to reactivate account.', 'isCreated' => false]);
        }

        mysqli_stmt_close($stmt_reactivate);
        return;
    } 

    $sql = "INSERT INTO users (full_name, email, password_hash, user_type, email_verification_token, is_verified)
            VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $fullname, $email, $password, $userType, $verificationToken);

    $data = [
        'fullname' => $fullname,
        'email' => $email,
        'password' => $password,
        'userType' => $userType
        //'verification_code' => $verification_code
    ];


    if (mysqli_stmt_execute($stmt)) {

        require(__DIR__ . "/../emails/confirm-email.php");
        if($message && $message === 'sent') {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Registration successful! Please check your email to verify your account.', 'isCreated' => true, 'data' => $data ]);
        }else {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'User registered, but email failed to send to '.$fullname.'!', 'isCreated' => false]);
        }
        
    } else {
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Failed to create user!', 'isCreated' => false]);
    }
    
    mysqli_stmt_close($stmt);
    
}

/**
 * Authenticates a user by email and password
 * Verifies the password against the stored hash
 */
function authenticateUser() {
    global $connect;
    
    $email = isset($_GET['data']['email']) ? $_GET['data']['email'] : null;
    $password = isset($_GET['data']['password']) ? $_GET['data']['password'] : null;
    
    if (!$email || !$password) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        return;
    }
    
    // Query to find user by email
    $sql = "SELECT id, full_name, email, password_hash, user_type FROM users WHERE email = ? AND is_active = 1";
    $stmt = mysqli_prepare($connect, $sql);
    
    if (!$stmt) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database error']);
        return;
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['full_name'];
            $_SESSION['fullname'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['user_type'];
            
            // Remove password from response
            unset($user['password_hash']);

            // Update last activity time
            $_SESSION['LAST_ACTIVITY'] = time();
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful',
                'user' => [
                    'id' => $user['id'],
                    'fullname' => $user['full_name'],
                    'email' => $user['email'],
                    'userType' => $user['user_type']
                ]
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
    
    mysqli_stmt_close($stmt);
}

try {
    
    if ($service === 'create_user') {
        createUser();
    } elseif ($service === 'authenticate_user') {
        authenticateUser();
    }
    
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Oops, something went wrong!', 'error' => $e->getMessage()]);
} finally {
    mysqli_close($connect);
}

?>