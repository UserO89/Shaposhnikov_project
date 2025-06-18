<?php
include_once 'partials/header.php';
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/Course.php';
require_once __DIR__ . '/../Classes/User.php';

$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$auth = new Auth();
$user = $auth->getUser();

$courseObj = new Course();
$userObj = new User();
$course = $courseObj->getById($courseId);
$reviews = $courseObj->getReviews($courseId);
$isEnrolled = $user ? $userObj->isUserEnrolled($user['id'], $courseId) : false;
?>

    <main class="container my-5">
        </section>
        <?php if ($course): ?>
            <div class="row">
                <div class="col-md-8">
                    <h1 class="mb-4"><?= htmlspecialchars($course['title']) ?></h1>
                    <div class="card mb-4">
                        <img src="<?= htmlspecialchars($course['image_url'] ?: BASE_PATH . '/assets/img/placeholder.png') ?>" 
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
                                <?php if ($user): ?>
                                    <?php if ($isEnrolled): ?>
                                        <a href="#" class="btn btn-success w-100 disabled">Enrolled <i class="fas fa-check"></i></a>
                                        <button type="button" class="btn btn-primary w-100 mt-2">Continue Learning</button>
                                    <?php else: ?>
                                        <form action="<?= BASE_PATH ?>/actions/auth/EnrollCourse.php" method="POST">
                                            <input type="hidden" name="course_id" value="<?= htmlspecialchars($courseId) ?>">
                                            <button type="submit" class="btn btn-primary w-100">Enroll Now</button>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Login to Enroll</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($reviews)): ?>
                        <?php include __DIR__ . '/partials/reviews_block.php'; ?>
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
    <?php include 'partials/footer.php'; ?>