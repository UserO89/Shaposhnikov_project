<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка прав администратора
Auth::requireAdmin();

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $courseId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($courseId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT id, title, description, duration, price, image_url FROM courses WHERE id = ?");
            $stmt->execute([$courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($course) {
                echo json_encode($course);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Course not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid course ID']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Course ID not provided']);
}
?> 