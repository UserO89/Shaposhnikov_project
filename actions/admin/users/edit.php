<?php
require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../../Classes/Auth.php';
require_once __DIR__ . '/../../../Classes/User.php';
require_once __DIR__ . '/../../../Classes/Validator.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception('Invalid user ID');
        }

        $userData = [
            'id' => $id,
            'username' => trim($_POST['username'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'role' => $_POST['role'] ?? 'student'
        ];

        if (!empty($_POST['password'])) {
            $userData['password'] = trim($_POST['password']);
        }

        $validator = new Validator();
        if (!$validator->validateUserData($userData, true)) {
            SessionMessage::set('danger', $validator->getFirstError());
            header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
            exit();
        }

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

header('Location:' . BASE_PATH . '/templates/admin/admin_users.php');
exit(); 