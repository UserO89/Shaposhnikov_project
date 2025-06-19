<?php
require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../../Classes/Auth.php';
require_once __DIR__ . '/../../../Classes/Course.php'; 


Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $course = new Course();
        $courseId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$courseId) {
            SessionMessage::set('danger', 'Wrong course ID');
            header('Location: ' . BASE_PATH . '/templates/admin/admin_courses.php');
            exit();
        }
        $deleted = $course->delete($courseId);
        if ($deleted) {
            SessionMessage::set('success', 'Course deleted successfully.');
        } else {
            SessionMessage::set('danger', 'Course not found or could not be deleted.');
        }
    } catch (PDOException $e) {
        SessionMessage::set('danger', 'DB error: ' . $e->getMessage());
        error_log("Database error deleting course: " . $e->getMessage());
    }
    header('Location: ' . BASE_PATH . '/templates/admin/admin_courses.php');
    exit();
} else {

    SessionMessage::set('danger', 'Invalid request method for course deletion.');
    header('Location: ' . BASE_PATH . '/templates/admin/admin_courses.php');
    exit();
}

?> 