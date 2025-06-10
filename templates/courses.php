<?php
$courses = json_decode(file_get_contents('../assets/info.json'), true);
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
      <?php foreach ($courses as $index => $course): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="<?= htmlspecialchars($course['image'] ?? 'https://via.placeholder.com/400x200') ?>" class="card-img-top" alt="Course image">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($course['desc']) ?></p>
              <a href="course.php?id=<?= $index ?>" class="btn btn-outline-primary mt-auto">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Footer -->
  <div id="footer">
    <?php include 'partials/footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
