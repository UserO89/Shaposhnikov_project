<?php
session_start();
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Check if user is admin
Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Connect to database
        $db = new Database();
        $conn = $db->getConnection();

        // Get form data
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $role = $_POST['role'] ?? 'user';

        // Validation
        $errors = [];
        if (empty($username)) {
            $errors[] = 'Username is required';
        }
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }
        if (empty($first_name)) {
            $errors[] = 'First name is required';
        }
        if (empty($last_name)) {
            $errors[] = 'Last name is required';
        }
        if (!$email) {
            $errors[] = 'Valid email is required';
        }
        if (!in_array($role, ['student', 'admin', 'teacher'])) {
            $errors[] = 'Invalid role';
        }

        // Check for duplicate username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username is already taken';
        }

        // Check for duplicate email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email is already taken';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Add user to database using prepared statement
        $sql = "INSERT INTO users (username, password, first_name, last_name, email, role) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $hashed_password, $first_name, $last_name, $email, $role]);

        $_SESSION['success'] = 'User added successfully';
    } 
    catch (PDOException $e) {
        // Check if the error is due to duplicate entry
        if ($e->getCode() === '23000') {
            $_SESSION['errors'] = ['Username or Email is already taken.'];
        } else {
            $_SESSION['errors'] = ['Database error: ' . $e->getMessage()];
        }
    }
} else {
    $_SESSION['errors'] = ['Invalid request method'];
}

// Go back to users page
header('Location: /Shaposhnikov_project/templates/admin/admin_users.php');
exit(); 