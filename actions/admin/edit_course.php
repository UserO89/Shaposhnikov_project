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

        // Получение данных из формы
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
        $image = trim($_POST['image_url'] ?? '');

        // Валидация данных
        $errors = [];
        if (!$id) {
            $errors[] = 'Неверный ID курса.';
        }
        if (empty($title)) {
            $errors[] = 'Название курса обязательно.';
        }
        if (empty($description)) {
            $errors[] = 'Описание курса обязательно.';
        }
        if (empty($duration)) {
            $errors[] = 'Продолжительность курса обязательна.';
        }
        if ($price === false || $price < 0) {
            $errors[] = 'Цена должна быть положительным числом.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
            exit();
        }

        // Обновление курса в базе данных
        $stmt = $conn->prepare("UPDATE courses SET title = ?, description = ?, duration = ?, price = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$title, $description, $duration, $price, $image, $id]);

        $_SESSION['success'] = 'Курс успешно обновлен.';

    } catch (PDOException $e) {
        $_SESSION['errors'][] = 'Ошибка базы данных: ' . $e->getMessage();
        error_log("Database error updating course: " . $e->getMessage());
    }

    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
} else {
    // Если запрос не POST, перенаправляем на страницу курсов
    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
}

?> 