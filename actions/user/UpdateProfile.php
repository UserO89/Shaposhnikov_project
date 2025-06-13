<?php
session_start();
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

error_log('UpdateProfile.php: Script started.');
error_log('UpdateProfile.php: POST data: ' . print_r($_POST, true));

try {
    if (!isset($_SESSION['user_id'])) {
        error_log('UpdateProfile.php: User not authenticated. Session user_id missing.');
        throw new Exception('User not authenticated');
    }

    $auth = new Auth();
    $user = $auth->getUser();

    if (!$user) {
        error_log('UpdateProfile.php: Authenticated user not found in database.');
        throw new Exception('User not found');
    }

    // Validate required fields
    $required_fields = ['username', 'email', 'first_name', 'last_name'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            error_log('UpdateProfile.php: Required field missing: ' . $field);
            throw new Exception("$field is required");
        }
    }

    // Validate email format
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        error_log('UpdateProfile.php: Invalid email format provided: ' . $_POST['email']);
        throw new Exception('Invalid email format');
    }

    // Check if username or email is already taken by another user
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$_POST['username'], $_POST['email'], $user['id']]);
    if ($stmt->rowCount() > 0) {
        error_log('UpdateProfile.php: Username or email already taken by another user.');
        throw new Exception('Username or email is already taken');
    }

    // Handle password update if provided
    $password_update = '';
    $params = [];
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) < 6) {
            error_log('UpdateProfile.php: Password too short.');
            throw new Exception('Password must be at least 6 characters long');
        }

        $password_update = ', password = ?';
        $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // Update user profile
    $sql = "UPDATE users SET \n            username = ?, \n            email = ?, \n            first_name = ?, \n            last_name = ?" .
            $password_update .
            " WHERE id = ?";

    $params = array_merge([
        $_POST['username'],
        $_POST['email'],
        $_POST['first_name'],
        $_POST['last_name']
    ], $params, [$user['id']]);

    error_log('UpdateProfile.php: SQL Query: ' . $sql);
    error_log('UpdateProfile.php: SQL Params: ' . print_r($params, true));

    $stmt = $conn->prepare($sql);
    if (!$stmt->execute($params)) {
        $errorInfo = $stmt->errorInfo();
        error_log('UpdateProfile.php: Database update failed. ErrorInfo: ' . print_r($errorInfo, true));
        throw new Exception('Failed to update profile');
    }

    error_log('UpdateProfile.php: Profile updated successfully.');
    $_SESSION['success_message'] = 'Profile updated successfully';
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();

} catch (Exception $e) {
    error_log('UpdateProfile.php: Caught exception: ' . $e->getMessage());
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();
} 