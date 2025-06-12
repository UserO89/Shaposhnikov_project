<?php
require_once __DIR__ . '/../Classes/Database.php';

$courses = [];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->query("SELECT id, title, description, duration, price, image_url FROM courses ORDER BY id DESC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error in courses.php: " . $e->getMessage());
    // Можно добавить сообщение об ошибке для пользователя, если нужно
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
</head>
<body>
  <!-- Header -->
  <div id="header">
    <?php include 'partials/header.php'; ?>
  </div>

  <main class="container my-5">
    <h2 class="text-center mb-4">All Available Courses</h2>
    <div class="row">
      <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <img src="<?= htmlspecialchars($course['image_url'] ?? 'https://via.placeholder.com/400x200') ?>" class="card-img-top" alt="Course image">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                <a href="course.php?id=<?= htmlspecialchars($course['id']) ?>" class="btn btn-outline-primary mt-auto">View Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info text-center">No courses available.</div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
