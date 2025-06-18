<?php
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Course.php';

$auth = new Auth();
Auth::requireAdmin();

$course = new Course();

$courses = $course->getAll();
$categories = $course->getAllCategories(); 
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../partials/admin_sidebar.php'; ?>
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