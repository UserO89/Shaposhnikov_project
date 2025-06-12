<?php
// Включаем отображение ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверяем, что сессия запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Определяем базовый путь
if (!isset($base_path)) {
    $base_path = '/Shaposhnikov_project'; 
}

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка прав администратора
Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Получение ID курса из формы
        $courseId = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);

        if (!$courseId) {
            $_SESSION['errors'][] = 'Неверный ID курса.';
            header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
            exit();
        }

        // Удаление курса из базы данных
        $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$courseId]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = 'Курс успешно удален.';
        } else {
            $_SESSION['errors'][] = 'Курс с указанным ID не найден.';
        }

    } catch (PDOException $e) {
        $_SESSION['errors'][] = 'Ошибка базы данных: ' . $e->getMessage();
        error_log("Database error deleting course: " . $e->getMessage());
    }

    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
} else {
    // Если запрос не POST, перенаправляем на страницу курсов
    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
}

?> 