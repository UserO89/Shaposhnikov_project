<?php
require_once __DIR__ . '/../Classes/Database.php';

// Get course ID from URL
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$course = null;
$reviews = [];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

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
                                    <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($course['duration']) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Price
                                    <span class="text-primary fw-bold">$<?= number_format($course['price'], 2) ?></span>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100">Enroll Now</button>
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
</body>
</html>
