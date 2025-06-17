<?php
include_once 'partials/header.php'; 
require_once __DIR__ . '/../Classes/Course.php';



$course = new Course();
$categories = $course->getAllCategories(); // Fetch all categories

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
    $courses = []; // Ensure courses array is empty on error
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Courses - CourseCo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/course.css">
</head>
<body>
    <main class="container my-5">
    <h2 class="text-center mb-4">All Available Courses</h2>
    
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-2">
            <?php include 'partials/course_filters.php'; ?>
        </div>

        <!-- Course Listings -->
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

