<?php
session_start();
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'An unknown error occurred.'
];

try {
    $auth = new Auth();
    $user = $auth->getUser();

    if (!$user) {
        throw new Exception('User not logged in.');
    }

    if (!isset($_POST['course_id'])) {
        throw new Exception('Course ID not provided.');
    }

    $courseId = (int)$_POST['course_id'];
    $userId = $user['id'];

    $db = new Database();
    $conn = $db->getConnection();

    // Check if the course exists
    $stmt = $conn->prepare("SELECT id FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        throw new Exception('Course not found.');
    }

    // Check if user is already enrolled in this course
    $stmt = $conn->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        throw new Exception('You are already enrolled in this course.');
    }

    // Enroll the user in the course
    $stmt = $conn->prepare("INSERT INTO user_courses (user_id, course_id, progress, is_completed) VALUES (?, ?, 0, FALSE)");
    if ($stmt->execute([$userId, $courseId])) {
        $response['success'] = true;
        $response['message'] = 'Successfully enrolled in the course!';
    } else {
        throw new Exception('Failed to enroll in the course.');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?> 