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
        $validator = new Validator(); // Хотя Validator может быть встроен в Course, для консистентности оставим

        // Получение данных из формы
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'duration' => trim($_POST['duration'] ?? ''),
            'price' => filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT),
            'image' => trim($_POST['image_url'] ?? '')
        ];

        if (!$id) {
            throw new Exception('Invalid course ID provided for update.');
        }

        // Обновление курса с помощью класса Course
        // Метод update() в классе Course уже содержит вызов validateCourseData()
        $course->update($id, $data);

        SessionMessage::set('success', 'The course data is changed successfully!');

    } catch (Exception $e) {
        SessionMessage::set('danger', $e->getMessage());
        error_log("Error updating course: " . $e->getMessage());
    }

    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
} else {
    // Если запрос не POST, перенаправляем на страницу курсов
    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
}

?> 