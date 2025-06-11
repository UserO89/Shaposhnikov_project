<?php
session_start();
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Check if user is admin
$auth = new Auth();
if (!$auth->isAdmin()) {
    header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
    exit();
}

// Get user id from form
$user_id = $_POST['user_id'];

// Connect to database
$db = new Database();
$conn = $db->getConnection();

// Delete user
$sql = "DELETE FROM users WHERE id = $user_id";
$conn->query($sql);

header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
exit(); 