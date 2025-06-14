<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Определяем базовый путь
if (!isset($base_path)) {
    $base_path = '/Shaposhnikov_project'; 
}

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Course.php'; // Подключаем класс Course

// Проверка прав администратора
Auth::requireAdmin();

if (isset($_GET['id'])) { // Изменено на проверку GET-параметра 'id'
    try {
        $course = new Course();

        // Получение ID курса из GET-параметра
        $courseId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$courseId) {
            $_SESSION['errors'][] = 'Wrong course ID';
            header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
            exit();
        }

        $deleted = $course->delete($courseId);

        if ($deleted) {
            $_SESSION['message'] = 'Course deleted succesfully.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['errors'][] = 'Course not found';
        }

    } catch (PDOException $e) {
        $_SESSION['errors'][] = 'DB error: ' . $e->getMessage();
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