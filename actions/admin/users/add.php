<?php
require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../../Classes/Auth.php';
require_once __DIR__ . '/../../../Classes/User.php';
require_once __DIR__ . '/../../../Classes/Validator.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepare user data
        $userData = [
            'username' => trim($_POST['username'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'role' => $_POST['role'] ?? 'student'
        ];

        $validator = new Validator();
        if (!$validator->validateUserData($userData)) {
            SessionMessage::set('danger', $validator->getFirstError());
            header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
            exit();
        }

        $user = new User();
        $userId = $user->create($userData);

        if ($userId) {
            SessionMessage::set('success', 'User added successfully');
        } else {
            throw new Exception('Failed to create user');
        }
    } catch (Exception $e) {
        SessionMessage::set('danger', 'Error: ' . $e->getMessage());
    }
} else {
    SessionMessage::set('danger', 'Invalid request method');
}

header('Location:' . BASE_PATH . '/templates/admin/admin_users.php');
exit(); 