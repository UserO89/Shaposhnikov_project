<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/Database.php';

// Get course ID from URL
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$course = null;
$reviews = [];
$isEnrolled = false;
$enrollmentId = null;

$auth = new Auth();
$user = $auth->getUser(); // Get current user data

try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course && $user) {
        // Check if user is already enrolled in this course
        $stmtEnrollment = $conn->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
        $stmtEnrollment->execute([$user['id'], $courseId]);
        $existingEnrollment = $stmtEnrollment->fetch(PDO::FETCH_ASSOC);
        if ($existingEnrollment) {
            $isEnrolled = true;
            $enrollmentId = $existingEnrollment['id'];
        }
    }

    // Fetch reviews for the course
    if ($course) {
        $stmtReviews = $conn->prepare("
            SELECT r.*, u.first_name, u.last_name
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.course_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmtReviews->execute([$courseId]);
        $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    error_log("Database error in course.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['title'] ?? 'Course Details') ?> - CourseCo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <div id="header">
        <?php include 'partials/header.php'; ?>
    </div>

    <main class="container my-5">
        <?php if ($course): ?>
            <div class="row">
                <div class="col-md-8">
                    <h1 class="mb-4"><?= htmlspecialchars($course['title']) ?></h1>
                    <div class="card mb-4">
                        <img src="<?= htmlspecialchars($course['image_url'] ?? 'https://via.placeholder.com/800x400') ?>" 
                             class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>"
                             style="max-height: 400px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Course Details</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Duration
                                    <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($course['duration'] ?? 'N/A') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Price
                                    <span class="text-primary fw-bold">$<?= number_format($course['price'] ?? 0, 2) ?></span>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <?php if ($user): // Only show button if user is logged in ?>
                                    <?php if ($isEnrolled): ?>
                                        <a href="#" class="btn btn-success w-100 disabled">Enrolled <i class="fas fa-check"></i></a>
                                        <button type="button" class="btn btn-primary w-100 mt-2">Continue Learning</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary w-100" id="enrollButton" data-course-id="<?= htmlspecialchars($courseId) ?>">Enroll Now</button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Login to Enroll</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($reviews)): ?>
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5 class="card-title">Customer Reviews</h5>
                                <?php foreach ($reviews as $review): ?>
                                    <div class="mb-3 pb-3 border-bottom">
                                        <p class="mb-1">
                                            <strong><?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']) ?></strong>
                                            <small class="text-muted float-end">
                                                <?= htmlspecialchars(date('M d, Y', strtotime($review['created_at']))) ?>
                                            </small>
                                        </p>
                                        <div>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa<?= ($i <= $review['rating']) ? 's' : 'r' ?> fa-star text-warning"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="mt-2">"<?= nl2br(htmlspecialchars($review['text'])) ?>"</p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif ($course): ?>
                        <div class="alert alert-info mt-4">No reviews yet for this course.</div>
                    <?php endif; ?>

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Course not found. Please check the URL and try again.
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php include 'partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enrollButton = document.getElementById('enrollButton');
            if (enrollButton) {
                enrollButton.addEventListener('click', function() {
                    const courseId = this.dataset.courseId;
                    
                    fetch('../actions/user/EnrollCourse.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'course_id=' + courseId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.reload(); // Reload to show updated status
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred during enrollment.');
                    });
                });
            }
        });
    </script>
</body>
</html>
