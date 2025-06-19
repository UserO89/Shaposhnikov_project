<?php
require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../../Classes/Auth.php';
require_once __DIR__ . '/../../../Classes/Database.php';

Auth::requireAdmin();

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($userId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT id, username, first_name, last_name, email, role FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid user ID']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'User ID not provided']);
}
?> 