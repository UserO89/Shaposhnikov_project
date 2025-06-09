<?php
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка прав администратора
Auth::requireAdmin();

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: users.php');
    exit;
}

// Получение данных из формы
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';

// Валидация данных
$errors = [];

if (empty($username)) {
    $errors[] = "Username is required";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (empty($password)) {
    $errors[] = "Password is required";
} elseif (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters long";
}

if (!in_array($role, ['user', 'admin'])) {
    $errors[] = "Invalid role";
}

// Если есть ошибки, возвращаемся на страницу пользователей
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: users.php');
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // Проверка существования пользователя
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['errors'] = ["Username or email already exists"];
        header('Location: users.php');
        exit;
    }
    
    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Добавление пользователя
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword, $role]);
    
    $_SESSION['success'] = "User added successfully";
    
} catch (PDOException $e) {
    $_SESSION['errors'] = ["Database error: " . $e->getMessage()];
}

header('Location: users.php');
exit; 