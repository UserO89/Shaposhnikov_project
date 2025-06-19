<?php
require_once  __DIR__ . '/../../../config/app.php';
require_once  __DIR__ . '/../../../Classes/SessionMessage.php';
require_once  __DIR__ . '/../../../Classes/Auth.php';
require_once  __DIR__ . '/../../../Classes/Course.php'; 
require_once  __DIR__ . '/../../../Classes/Validator.php'; 

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $course = new Course();
        $validator = new Validator(); 

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

        $course->update($id, $data);

        SessionMessage::set('success', 'The course data is changed successfully!');

    } catch (Exception $e) {
        SessionMessage::set('danger', $e->getMessage());
        error_log("Error updating course: " . $e->getMessage());
    }

    header('Location: ' . BASE_PATH . '/templates/admin/admin_courses.php');
    exit();
} else {
    header('Location: ' . BASE_PATH . '/templates/admin/admin_courses.php');
    exit();
}

?> 