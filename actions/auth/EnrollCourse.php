<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

$auth = new Auth();
$user = $auth->getUser();

if (!isset($_POST['course_id'])) {
    SessionMessage::set('danger', "Invalid course selection.");
    header("Location:" . BASE_PATH . "/templates/course.php?id=" . $_POST['course_id']);
    exit;
}

$courseId = (int)$_POST['course_id'];

if (!$user) {
    SessionMessage::set('danger', "You must be logged in to enroll in a course.");
    header("Location:" . BASE_PATH . "/templates/course.php?id=" . $courseId);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$user['id'], $courseId]);
    if ($stmt->fetch()) {
        SessionMessage::set('warning', "You are already enrolled in this course.");
        header("Location:" . BASE_PATH . "/templates/course.php?id=" . $courseId);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO user_courses (user_id, course_id, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$user['id'], $courseId]);

    SessionMessage::set('success', "Successfully enrolled in the course!");
    header("Location:" . BASE_PATH . "/templates/course.php?id=" . $courseId);
    exit;

} catch (PDOException $e) {
    error_log("Enrollment error: " . $e->getMessage());
    SessionMessage::set('danger', "An error occurred while enrolling in the course.");
    header("Location:" . BASE_PATH . "/templates/course.php?id=" . $courseId);
    exit;
} 