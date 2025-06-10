<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка прав администратора
// Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Получаем данные из формы
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $username = trim($_POST['username'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $role = $_POST['role'] ?? 'user';
        $password = trim($_POST['password'] ?? '');

        // Валидация данных
        $errors = [];
        if (!$id) {
            $errors[] = 'Invalid user ID';
        }
        if (empty($username)) {
            $errors[] = 'Username is required';
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
        if (!in_array($role, ['user', 'admin'])) {
            $errors[] = 'Invalid role';
        }
        if ($password && strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: admin_users.php');
            exit();
        }

        // Проверяем, не занят ли username другим пользователем
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $id]);
        if ($stmt->fetch()) {
            $_SESSION['errors'] = ['Username is already taken'];
            header('Location: admin_users.php');
            exit();
        }

        // Проверяем, не занят ли email другим пользователем
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            $_SESSION['errors'] = ['Email is already taken'];
            header('Location: admin_users.php');
            exit();
        }

        // Обновляем данные пользователя
        if ($password) {
            // Если указан новый пароль, обновляем и его
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, role = ?, password = ? WHERE id = ?");
            $stmt->execute([$username, $first_name, $last_name, $email, $role, $hashed_password, $id]);
        } else {
            // Если пароль не указан, оставляем старый
            $stmt = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $first_name, $last_name, $email, $role, $id]);
        }

        $_SESSION['success'] = 'User updated successfully';
    } catch (PDOException $e) {
        $_SESSION['errors'] = ['Database error: ' . $e->getMessage()];
    }
} else {
    $_SESSION['errors'] = ['Invalid request method'];
}

header('Location: admin_users.php');
exit(); 