<?php
// Получаем ID курса из URL
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$courses = json_decode(file_get_contents('../assests/courses.json'), true);
$reviews = json_decode(file_get_contents('../assests/reviews.json'), true);
$course = $courses[$courseId] ?? null;
$courseReviews = array_values(array_filter($reviews, fn($r) => $r['course_id'] === $courseId));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $course ? htmlspecialchars($course['title']) : 'Course Not Found' ?> - CourseCo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .course-header {
      background-color: #0056b3;
      color: white;
      padding: 3rem 1rem;
      text-align: center;
    }
    .course-content {
      max-width: 900px;
      margin: 3rem auto;
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .course-image {
      width: 100%;
      border-radius: 1rem;
      margin-bottom: 1rem;
    }
    .btn-enroll {
      background-color: #0056b3;
      border: none;
      border-radius: 50px;
      padding: 0.6rem 1.5rem;
    }
    .reviews, .source-info {
      margin-top: 2rem;
    }
    .carousel-item {
      text-align: center;
    }
    .review-card {
      max-width: 600px;
      margin: 0 auto;
      padding: 1rem;
      background-color: #f8f9fa;
      border-left: 4px solid #0056b3;
      border-radius: 0.5rem;
    }
    .review-photo {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body>
  <!-- Вставка header -->
  <div id="header"> <?php include 'partials/header.php'; ?></div>

  <?php if ($course): ?>
    <div class="course-header">
      <h1><?= htmlspecialchars($course['title']) ?></h1>
      <p><?= htmlspecialchars($course['level'] ?? 'Level: Not specified') ?> • <?= htmlspecialchars($course['duration'] ?? 'Duration: N/A') ?></p>
    </div>

    <div class="course-content">
      <img src="<?= htmlspecialchars($course['image'] ?? 'https://via.placeholder.com/800x300') ?>" alt="Course Image" class="course-image">

      <h4>Description</h4>
      <p><?= htmlspecialchars($course['desc']) ?></p>

      <h4>What You Will Learn</h4>
      <ul>
        <li>Foundational knowledge in the subject</li>
        <li>Hands-on projects and assessments</li>
        <li>Certificate upon completion</li>
        <li>Access to resources and mentorship</li>
      </ul>

      <h4>Price</h4>
      <p><strong><?= htmlspecialchars($course['price'] ?? 'Free') ?></strong></p>

      <div class="text-center">
        <a href="#" class="btn btn-enroll">Enroll Now</a>
      </div>

      <!-- Отзывы студентов в карусели -->
      <div class="reviews">
        <h4>Student Reviews</h4>
        <?php if ($courseReviews): ?>
          <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
              <?php foreach ($courseReviews as $index => $review): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                  <div class="review-card">
                    <?php if (!empty($review['photo'])): ?>
                      <img src="<?= htmlspecialchars($review['photo']) ?>" class="review-photo" alt="Reviewer Photo">
                    <?php endif; ?>
                    <h6 class="mb-1"><?= htmlspecialchars($review['name']) ?></h6>
                    <p class="text-muted"><em><?= htmlspecialchars($review['text']) ?></em></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
        <?php else: ?>
          <p>No reviews yet for this course.</p>
        <?php endif; ?>
      </div>

      <!-- Информация об источнике -->
      <div class="source-info">
        <h6 class="text-muted">Information Source</h6>
        <p>This course information is provided by CourseCo and compiled from certified instructors and open education providers.</p>
      </div>

    </div>
  <?php else: ?>
    <div class="container text-center mt-5">
      <h2>Course not found</h2>
      <p>Please check the link or return to the courses page.</p>
    </div>
  <?php endif; ?>

  <!-- Вставка footer -->
  <div id="footer"> <?php include 'partials/footer.php'; ?></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
