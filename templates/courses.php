<?php
require_once __DIR__ . '/../Classes/Course.php';

$course = new Course();
$courses = [];
$categories = $course->getAllCategories(); // Fetch all categories

try {
    $filters = [];
    if (isset($_GET['category']) && $_GET['category'] !== '') {
        $filters['category'] = $_GET['category'];
    }
    if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
        $filters['min_price'] = $_GET['min_price'];
    }
    if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
        $filters['max_price'] = $_GET['max_price'];
    }
    if (isset($_GET['max_duration']) && is_numeric($_GET['max_duration'])) {
        $filters['max_duration'] = $_GET['max_duration'];
    }

    $courses = $course->getFilteredCourses($filters);

} catch (Exception $e) {
    error_log("Error loading courses: " . $e->getMessage());
    // Optionally, set a user-friendly error message
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
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/course.css">
</head>
<body>
  <!-- Header -->
  <div id="header">
    <?php include 'partials/header.php'; ?>
  </div>

  <main class="container my-5">
    <h2 class="text-center mb-4">All Available Courses</h2>
    
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-2">
            <div class="card mb-4">
                <div class="card-header">Filter Courses</div>
                <div class="card-body">
                    <form action="courses.php" method="GET">
                        <div class="mb-3">
                            <label for="categoryFilter" class="form-label">Category</label>
                            <select class="form-select" id="categoryFilter" name="category">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat['name']); ?>"
                                        <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['name']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="minPrice" class="form-label">Min Price</label>
                            <input type="number" step="0.01" class="form-control" id="minPrice" name="min_price" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="maxPrice" class="form-label">Max Price</label>
                            <input type="number" step="0.01" class="form-control" id="maxPrice" name="max_price" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="durationFilter" class="form-label">Max Duration (hours)</label>
                            <input type="number" class="form-control" id="durationFilter" name="max_duration" value="<?php echo htmlspecialchars($_GET['max_duration'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="courses.php" class="btn btn-secondary mt-2">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Course Listings -->
        <div class="col-md-10">
            <div class="row course-listings">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?= htmlspecialchars($course['image_url'] ?? 'https://via.placeholder.com/400x200') ?>" class="card-img-top" alt="Course image">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                    <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($course['category'] ?? 'N/A') ?></p>
                                    <p class="card-text"><strong>Duration:</strong> <?= htmlspecialchars($course['duration'] ?? 'N/A') ?> hours</p>
                                    <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($course['price'] ?? 'N/A') ?></p>
                                    <a href="course.php?id=<?= htmlspecialchars($course['id']) ?>" class="btn btn-outline-primary mt-auto">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">No courses available matching your filters.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

