<?php
session_start();
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/User.php';
require_once __DIR__ . '/../../Classes/Validator.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';

error_log('UpdateProfile.php: Script started.');
error_log('UpdateProfile.php: POST data: ' . print_r($_POST, true));

try {
    if (!isset($_SESSION['user']['id'])) {
        error_log('UpdateProfile.php: User not authenticated. Session user_id missing.');
        SessionMessage::set('danger', 'User not authenticated');
        header('Location: /Shaposhnikov_project/templates/profile.php');
        exit();
    }

    $auth = new Auth();
    $user = $auth->getUser();

    if (!$user) {
        error_log('UpdateProfile.php: Authenticated user not found in database.');
        SessionMessage::set('danger', 'User not found');
        header('Location: /Shaposhnikov_project/templates/profile.php');
        exit();
    }

    // Prepare user data for update
    $userData = [
        'id' => $user['id'],
        'username' => trim($_POST['username']),
        'email' => trim($_POST['email']),
        'first_name' => trim($_POST['first_name']),
        'last_name' => trim($_POST['last_name']),
        'role' => $user['role'] // Preserve existing role
    ];

    // Add password if provided
    if (!empty($_POST['password'])) {
        $userData['password'] = $_POST['password'];
    }

    // Validate data
    $validator = new Validator();
    if (!$validator->validateUserData($userData, true)) {
        $errors = $validator->getErrors();
        error_log('UpdateProfile.php: Validation errors: ' . print_r($errors, true));
        SessionMessage::set('danger', $validator->getFirstError());
        header('Location: /Shaposhnikov_project/templates/profile.php');
        exit();
    }

    // Update user profile using User class
    $userObj = new User();
    $userObj->update($user['id'], $userData);

    SessionMessage::set('success', 'Profile updated successfully');
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();

} catch (Exception $e) {
    error_log('UpdateProfile.php: Caught exception: ' . $e->getMessage());
    SessionMessage::set('danger', $e->getMessage());
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();
} 