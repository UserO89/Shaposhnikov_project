<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/../Classes/Database.php';
require_once __DIR__ . '/../Classes/Course.php';

$courses = [];
$reviews = [];

$db = new Database();
$conn = $db->getConnection();
$courseObj = new Course();

// Get latest 6 courses for featured
$courses = $courseObj->getLatest(6);

// Fetch reviews along with user names
$stmt = $conn->query("SELECT r.text, r.rating, u.first_name, u.last_name FROM reviews r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC LIMIT 5");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div>
      <h1 class="display-4">Master New Skills Online</h1>
      <p class="lead">Explore our wide selection of professional courses</p>
      <a href="/Shaposhnikov_project/templates/courses.php" class="btn btn-lg btn-primary">Browse Courses</a>
    </div>
  </section>

  <!-- Main Content -->
  
  <main class="container my-5">
        <!-- About Us -->
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
    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner" id="carouselContent">
        <?php if (!empty($courses)): ?>
          <?php
          $course_chunks = array_chunk($courses, 3); // Group courses into chunks of 3 for slides
          foreach ($course_chunks as $index => $slide_courses):
            $isActive = $index === 0 ? 'active' : '';
          ?>
            <div class="carousel-item <?= $isActive ?>">
              <div class="row justify-content-center">
                <?php foreach ($slide_courses as $course): ?>
                  <div class="col-md-4">
                    <div class="card h-100 shadow-sm course-card">
                      <img src="<?= htmlspecialchars($course['image_url'] ?? '/Shaposhnikov_project/assets/img/default-course.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                      <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate"> <a href="/Shaposhnikov_project/templates/course.php?id=<?= htmlspecialchars($course['id']) ?>" class="text-decoration-none text-dark stretched-link"><?= htmlspecialchars($course['title']) ?></a></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($course['description']) ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                          <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($course['duration']) ?></span>
                          <span class="fw-bold text-success"><?= '$' . number_format($course['price'], 2) ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="carousel-item active">
            <div class="row justify-content-center">
              <div class="col-12">
                <div class="alert alert-info text-center">No featured courses available.</div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <!-- Testimonials -->
    <section class="my-5">
      <h3 class="text-center mb-4">What Our Students Say</h3>
      <div id="homeReviewCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center px-5">
          <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $index => $review): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <blockquote class="blockquote">
                  <p class="mb-3">“<?= htmlspecialchars($review['text']) ?>”</p>
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
                <p class="mb-3">“No reviews available yet. Be the first to share your experience!”</p>
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

    <!-- Call to Action -->
    <section class="text-center my-5 py-5 bg-primary text-white rounded">
      <h2 class="mb-3">Ready to level up your career?</h2>
      <p class="mb-4">Join thousands of students who are growing with CourseCo.</p>
      <a href="/Shaposhnikov_project/templates/courses.php" class="btn btn-light btn-lg px-4">Explore Courses</a>
    </section>
  </main>

  <!-- Footer -->
    <?php include __DIR__ . '/partials/footer.php'; ?>

  <script>
    // fetch('/Shaposhnikov_project/assets/info.json')
    //   .then(res => res.json())
    //   .then(courses => {
    //     const itemsPerSlide = 3;
    //     const carouselContent = document.getElementById('carouselContent');

    //     for (let i = 0; i < courses.length; i += itemsPerSlide) {
    //       const slideCourses = courses.slice(i, i + itemsPerSlide);
    //       const isActive = i === 0 ? 'active' : '';
    //       const slide = document.createElement('div');
    //       slide.className = `carousel-item ${isActive}`;
    //       const row = document.createElement('div');
    //       row.className = 'row justify-content-center';

    //       slideCourses.forEach(course => {
    //         const col = document.createElement('div');
    //         col.className = 'col-md-4';
    //         col.innerHTML = `
    //           <div class="card">
    //             <div class="card-body">
    //               <h5 class="card-title">${course.title}</h5>
    //               <p class="card-text">${course.desc}</p>
    //               <a href="#" class="btn btn-outline-primary">Learn More</a>
    //             </div>
    //           </div>
    //         `;
    //         row.appendChild(col);
    //       });

    //       slide.appendChild(row);
    //       carouselContent.appendChild(slide);
    //     }
    //   });
  </script>
  
  <style>
    .hero {
      height: 60vh;
      background-image: url('/Shaposhnikov_project/assets/img/banner.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }
    .hero h1 {
      font-size: 3rem;
    }
    .hero p {
      font-size: 1.25rem;
    }
  </style>
</body>
</html>