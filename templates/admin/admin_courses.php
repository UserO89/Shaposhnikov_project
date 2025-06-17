<?php
require_once __DIR__ . '/../../config/app.php'; // Include the central config file
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Course.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php'; // Add this line

$auth = new Auth();
Auth::requireAdmin(); // Ensure admin access

$course = new Course();

$courses = $course->getAll();
$categories = $course->getAllCategories(); // Fetch all categories

// Include header after all PHP operations
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH ?>/templates/admin/admin_dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= BASE_PATH ?>/templates/admin/admin_users.php">
                            <i class="fas fa-users me-2"></i>
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="<?= BASE_PATH ?>/templates/admin/admin_courses.php">
                            <i class="fas fa-book me-2"></i>
                            Courses
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Course Management</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus"></i> Add Course
                </button>
            </div>

            <?php renderFlashMessage();?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($courses as $course): ?>
                    <?php include __DIR__ . '/../partials/course_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../modals/admin/add_course.php'; ?>
<?php require_once __DIR__ . '/../modals/admin/edit_course.php'; ?>

<script src="<?= BASE_PATH ?>/assets/js/admin_courses.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 