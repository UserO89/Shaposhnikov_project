<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/../Classes/Database.php';
require_once __DIR__ . '/../Classes/Course.php';

$courses = [];
$reviews = [];

$db = new Database();
$conn = $db->getConnection();
$courseObj = new Course();
$courses = $courseObj->getTopRated(3);

// Fetch reviews along with user names
$stmt = $conn->query("SELECT r.text, r.rating, u.first_name, u.last_name FROM reviews r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC LIMIT 5");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="<?= htmlspecialchars(BASE_PATH) ?>/assets/css/home.css">

<section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div>
        <?php renderFlashMessage()?>
        <h1 class="display-4">Master New Skills Online</h1>
        <p class="lead">Explore our wide selection of professional courses</p>
        <a href="/Shaposhnikov_project/templates/courses.php" class="btn btn-lg btn-primary">Browse Courses</a>
    </div>
</section>
<main class="container my-5">
    <section class="my-5 px-3 py-4 bg-white rounded shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="/Shaposhnikov_project/assets/img/team.png" alt="Our Team" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h3>About CourseCo</h3>
                <p>CourseCo is a leading provider of high-quality online education. We partner with top instructors to bring you practical, engaging, and career-focused courses.</p>
                <ul>
                    <li>Professional and verified instructors</li>
                    <li>Certificates recognized by employers</li>
                    <li>24/7 access to all lessons</li>
                </ul>
            </div>
        </div>
    </section>
    <h2 class="text-center mb-4">Featured Courses</h2>
    <div class="row justify-content-center">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <?php include __DIR__ . '/partials/course_card.php'; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No featured courses available.</div>
            </div>
        <?php endif; ?>
    </div>
    <section class="my-5">
        <h3 class="text-center mb-4">What Our Students Say</h3>
        <div id="homeReviewCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner text-center px-5">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $index => $review): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <blockquote class="blockquote">
                                <p class="mb-3">"<?= htmlspecialchars($review['text']) ?>"</p>
                                <footer class="blockquote-footer">
                                    <?= htmlspecialchars($review['first_name'] . ' ' . substr($review['last_name'], 0, 1) . '.') ?>, Student
                                    <?php if (isset($review['rating'])): ?>
                                        <br>
                                        <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </footer>
                            </blockquote>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <blockquote class="blockquote">
                            <p class="mb-3">"No reviews available yet. Be the first to share your experience!"</p>
                            <footer class="blockquote-footer">Admin</footer>
                        </blockquote>
                    </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeReviewCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeReviewCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section class="text-center my-5 py-5 bg-primary text-white rounded">
        <h2 class="mb-3">Ready to level up your career?</h2>
        <p class="mb-4">Join thousands of students who are growing with CourseCo.</p>
        <a href="<?= BASE_PATH ?>/templates/courses.php" class="btn btn-light btn-lg px-4">Explore Courses</a>
    </section>
    </main>
    <?php include 'partials/footer.php'; ?>

