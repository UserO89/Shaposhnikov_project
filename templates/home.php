<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Company</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assests/css/style.css">
</head>

<body>

  <!-- Header Include -->
  <div id="header">
    <?php include 'partials/header.php'; ?>
  </div>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div>
      <h1 class="display-4">Master New Skills Online</h1>
      <p class="lead">Explore our wide selection of professional courses</p>
      <a href="#" class="btn btn-lg btn-primary">Browse Courses</a>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container my-5">
    <h2 class="text-center mb-4">Featured Courses</h2>
    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner" id="carouselContent">
        <!-- Dynamic slides will be injected here -->
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </main>
  <!-- Footer Include -->
  <div id="footer"> <?php include 'partials/footer.php'; ?> </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // fetch('header.php').then(res => res.text()).then(html => document.getElementById('header').innerHTML = html);
  // fetch('footer.html').then(res => res.text()).then(html => document.getElementById('footer').innerHTML = html);

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