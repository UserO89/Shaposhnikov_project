<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/../Classes/Course.php';

$course = new Course();
$categories = $course->getAllCategories();

try {
    $filters = array_filter([
        'category' => $_GET['category'] ?? '',
        'min_price' => is_numeric($_GET['min_price'] ?? '') ? $_GET['min_price'] : null,
        'max_price' => is_numeric($_GET['max_price'] ?? '') ? $_GET['max_price'] : null,
        'max_duration' => is_numeric($_GET['max_duration'] ?? '') ? $_GET['max_duration'] : null
    ]);
    
    $courses = $course->getFilteredCourses($filters);
} catch (Exception $e) {
    error_log("Error loading courses: " . $e->getMessage());
    $courses = [];
}
?>
<body>
    <main class="container my-5">
    <h2 class="text-center mb-4">All Available Courses</h2>
    
    <div class="row">
        <div class="col-md-2">
            <?php include 'partials/course_filters.php'; ?>
        </div>

        <section class="col-md-10">
            <div class="row course-listings">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <?php include __DIR__ . '/partials/course_card.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">No courses available matching your filters.</div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
  </main>
  <?php include 'partials/footer.php'; ?>

<?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
    <?php 
    $categories = (new Course())->getAllCategories();
    include __DIR__ . '/modals/admin/edit_course.php'; 
    ?>
    <script src="<?= BASE_PATH ?>/assets/js/admin_courses.js"></script>
<?php endif; ?>

