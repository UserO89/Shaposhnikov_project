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
require_once __DIR__ . '/../../Classes/Course.php'; // Убедимся, что класс Course доступен
require_once __DIR__ . '/../../Classes/Validator.php'; // Подключаем класс Validator
require_once __DIR__ . '/../../Classes/SessionMessage.php'; // Add this line

// Проверка прав администратора
Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $course = new Course();
        $validator = new Validator();

        // Получение данных из формы
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'category' => trim($_POST['category'] ?? ''), // Добавляем категорию
            'duration' => trim($_POST['duration'] ?? ''),
            'price' => filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT),
            'image' => trim($_POST['image_url'] ?? '') // Используем 'image' как ожидается в Course::create
        ];

        $course->create($data);

        SessionMessage::set('success', 'Course added successfully!');

    } catch (Exception $e) {
        // Если валидация или создание курса вызвали исключение
        SessionMessage::set('danger', $e->getMessage());
        error_log("Error adding course: " . $e->getMessage());
    }

    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
} else {
    // Если запрос не POST, перенаправляем на страницу курсов
    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
}

?> 