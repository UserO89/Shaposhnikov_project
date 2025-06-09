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

// Получение ID пользователя
$userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

if (!$userId) {
    $_SESSION['errors'] = ["Invalid user ID"];
    header('Location: users.php');
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // Проверка существования пользователя
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() === 0) {
        $_SESSION['errors'] = ["User not found"];
        header('Location: users.php');
        exit;
    }
    
    // Удаление пользователя
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    $_SESSION['success'] = "User deleted successfully";
    
} catch (PDOException $e) {
    $_SESSION['errors'] = ["Database error: " . $e->getMessage()];
}

header('Location: users.php');
exit; 