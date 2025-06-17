<?php
session_start();
require_once __DIR__ . '/../../../Classes/Auth.php';
require_once __DIR__ . '/../../../Classes/User.php';
require_once __DIR__ . '/../../../Classes/Validator.php';
require_once __DIR__ . '/../../../Classes/SessionMessage.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get user ID
        $id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception('Invalid user ID');
        }

        // Prepare user data
        $userData = [
            'id' => $id,
            'username' => trim($_POST['username'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'role' => $_POST['role'] ?? 'student'
        ];

        // Add password if provided
        if (!empty($_POST['password'])) {
            $userData['password'] = trim($_POST['password']);
        }

        // Validate data
        $validator = new Validator();
        if (!$validator->validateUserData($userData, true)) {
            SessionMessage::set('danger', $validator->getFirstError());
            header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
            exit();
        }

        // Update user
        $user = new User();
        if ($user->update($id, $userData)) {
            SessionMessage::set('success', 'User updated successfully');
        } else {
            throw new Exception('Failed to update user');
        }
    } catch (Exception $e) {
        SessionMessage::set('danger', 'Error: ' . $e->getMessage());
    }
} else {
    SessionMessage::set('danger', 'Invalid request method');
}

header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
exit(); 