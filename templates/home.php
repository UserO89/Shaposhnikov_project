<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Company</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assests/css/style.css">
  <style>
    .hero {
      height: 60vh;
      background-image: url('../assests/img/banner.jpg');
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
</head>

<body>
  <!-- Header -->
  <div id="header">
    <?php include 'partials/header.php'; ?>
  </div>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div>
      <h1 class="display-4">Master New Skills Online</h1>
      <p class="lead">Explore our wide selection of professional courses</p>
      <a href="courses.php" class="btn btn-lg btn-primary">Browse Courses</a>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container my-5">
    <h2 class="text-center mb-4">Featured Courses</h2>
    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner" id="carouselContent"></div>
      <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <!-- About Us -->
    <section class="my-5 px-3 py-4 bg-white rounded shadow-sm">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="../assests/img/team.png" alt="Our Team" class="img-fluid rounded">
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

    <!-- Testimonials -->
    <section class="my-5">
      <h3 class="text-center mb-4">What Our Students Say</h3>
      <div id="homeReviewCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center px-5">
          <div class="carousel-item active">
            <blockquote class="blockquote">
              <p class="mb-3">“The course helped me land my dream job in just 2 months.”</p>
              <footer class="blockquote-footer">Alex G., Web Developer</footer>
            </blockquote>
          </div>
          <div class="carousel-item">
            <blockquote class="blockquote">
              <p class="mb-3">“Well-structured content and great instructors. Highly recommend!”</p>
              <footer class="blockquote-footer">Sophie M., Data Analyst</footer>
            </blockquote>
          </div>
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
      <a href="courses.php" class="btn btn-light btn-lg px-4">Explore Courses</a>
    </section>
  </main>

  <!-- Footer -->
  <div id="footer"> 
    <?php include 'partials/footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    fetch('../assests/info.json')
      .then(res => res.json())
      .then(courses => {
        const itemsPerSlide = 3;
        const carouselContent = document.getElementById('carouselContent');

        for (let i = 0; i < courses.length; i += itemsPerSlide) {
          const slideCourses = courses.slice(i, i + itemsPerSlide);
          const isActive = i === 0 ? 'active' : '';
          const slide = document.createElement('div');
          slide.className = `carousel-item ${isActive}`;
          const row = document.createElement('div');
          row.className = 'row justify-content-center';

          slideCourses.forEach(course => {
            const col = document.createElement('div');
            col.className = 'col-md-4';
            col.innerHTML = `
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">${course.title}</h5>
                  <p class="card-text">${course.desc}</p>
                  <a href="#" class="btn btn-outline-primary">Learn More</a>
                </div>
              </div>
            `;
            row.appendChild(col);
          });

          slide.appendChild(row);
          carouselContent.appendChild(slide);
        }
      });
  </script>
</body>
</html>
