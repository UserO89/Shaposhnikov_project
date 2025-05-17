<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Course Company</title>
    <link rel="icon" type="image/png" href="../assests/img/logo/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assests/css/style.css">
    <style>
        .thank-you-section {
            height: 60vh;
            background-image: url('../assests/img/banner.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div id="header">
        <?php include 'partials/header.php'; ?>
    </div>

    <section class="thank-you-section text-center text-light d-flex align-items-center justify-content-center">
        <div>
            <h1 class="display-4">Thank You!</h1>
            <p class="lead">Your message has been received. We'll get back to you soon.</p>
            <a href="home.php" class="btn btn-lg btn-primary">Return to Home</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="text-center my-5 py-5 bg-primary text-white rounded">
            <h2 class="mb-3">What's Next?</h2>
            <p class="mb-4">Explore our courses and start your learning journey today.</p>
            <a href="courses.php" class="btn btn-light btn-lg px-4">Browse Courses</a>
        </section>
    </main>

    <!-- Footer -->
    <div id="footer">
        <?php include 'partials/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
