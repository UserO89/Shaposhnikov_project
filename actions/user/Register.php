<?php
session_start();

require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/User.php';

$auth = new Auth();
$user = new User();

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'username' => $_POST['username'] ?? '',
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
    ];

    // Check if the password and confirm_password match
    if ($userData['password'] !== $userData['confirm_password']) {
        $errors[] = 'Passwords do not match.';
    }

    // Determine if the user is an admin for role assignment
    $isAdmin = $auth->isLoggedIn() && $auth->isAdmin();

    if ($isAdmin && isset($_POST['role'])) {
        $userData['role'] = $_POST['role']; // Admin can set role
    } else {
        $userData['role'] = 'user'; // Default for public registration
    }

    if (empty($errors)) {
        try {
            $newUserId = $user->create($userData);
            
            if ($isAdmin) {
                $_SESSION['success_message'] = 'User ' . htmlspecialchars($userData['username']) . ' added successfully by admin!';
                header('Location: admin/admin_users.php'); // Redirect admin to user management page
                exit();
            } else {
                $_SESSION['success_message'] = 'Registration successful! Please login.';
                header('Location: login.php'); // Redirect public user to login page
                exit();
            }
        } catch (Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }
}

// If there are errors, store them in session and redirect back
if (!empty($errors)) {
    $_SESSION['registration_errors'] = $errors;
    // Redirect based on whether it's an admin creating a user or a public registration
    if ($auth->isLoggedIn() && $auth->isAdmin()) {
        header('Location: admin/admin_users.php');
    } else {
        header('Location: /?route=home'); // Redirect public user to home (where modal is)
    }
    exit();
}

// If accessed directly via GET, redirect to home or admin_users depending on role
if ($auth->isLoggedIn() && $auth->isAdmin()) {
    header('Location: admin/admin_users.php');
} else {
    header('Location: /?route=home');
}
exit();
?> 