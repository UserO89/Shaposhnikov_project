<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/User.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';

$auth = new Auth();
Auth::requireAdmin();

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $user = new User();
    if ($user->delete($user_id)) {
        SessionMessage::set('success', 'User deleted successfully.');
    } else {
        SessionMessage::set('danger', 'Failed to delete user or user not found.');
    }
} else {
    SessionMessage::set('danger', 'User ID not provided.');
}

header('Location: ' . BASE_PATH . '/templates/admin/admin_users.php');
exit(); 