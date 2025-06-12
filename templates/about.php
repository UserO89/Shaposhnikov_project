<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine the base path
if (!isset($base_path)) {
    $base_path = '/Shaposhnikov_project';
}

// Include header
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="card-title text-center mb-4">About Us</h1>
                    <p class="lead text-center mb-5">Welcome to CourseCo – Your Journey to Knowledge!</p>

                    <p>CourseCo is a leading online learning platform designed to provide high-quality courses in the most in-demand fields. Our mission is to make education accessible and engaging for everyone who strives for self-improvement and mastering new skills.</p>

                    <h2 class="mt-5 mb-3 text-center">Our Story</h2>
                    <p>The story of CourseCo began in **2018** with a simple yet profound vision: to bridge the gap between aspiring learners and the rapidly evolving demands of the modern world. Our founder, **Dr. Elena Petrova**, a passionate educator and technologist, observed how traditional learning methods struggled to keep pace with the swift advancements in various industries. She envisioned a platform that was not only flexible and accessible but also deeply engaging and tailored to individual learning paces.</p>

                    <p>Starting from a small shared office and a handful of pilot courses in **AI & Machine Learning**, CourseCo quickly gained traction. Our initial focus was on creating interactive, project-based curricula that allowed students to apply theoretical knowledge immediately. This hands-on approach, combined with dedicated instructor support, resonated deeply with our early users.</p>

                    <p>By **2020**, with the world shifting towards remote solutions, CourseCo experienced exponential growth. We expanded our course catalog to include **Web Development, Digital Marketing, Data Science, and Creative Arts**. We invested heavily in developing a robust, intuitive platform, integrating cutting-edge tools and a vibrant community forum where learners could collaborate and seek guidance.</p>

                    <p>Today, CourseCo stands as a testament to the power of accessible education. We boast a community of **hundreds of thousands of learners** from over **150 countries**, and our alumni have gone on to achieve remarkable success in their respective fields. We continue to innovate, constantly updating our courses, introducing new learning methodologies, and fostering a supportive global network. Our journey is far from over; we remain committed to empowering individuals to unlock their full potential and shape their futures through learning.</p>

                    <h2 class="mt-5 mb-3 text-center">Our Philosophy</h2>
                    <p>We believe that continuous learning is the key to personal and professional growth. Therefore, we strive to create not just an educational platform, but a dynamic community where students and instructors can exchange experiences, inspire each other, and reach new heights.</p>
                    <ul class="list-unstyled text-center d-flex justify-content-around mt-4">
                        <li><i class="fas fa-lightbulb fa-2x text-primary"></i><p class="mt-2">Innovation</p></li>
                        <li><i class="fas fa-users fa-2x text-primary"></i><p class="mt-2">Community</p></li>
                        <li><i class="fas fa-cogs fa-2x text-primary"></i><p class="mt-2">Quality</p></li>
                    </ul>

                    <h2 class="mt-5 mb-3 text-center">Our Team</h2>
                    <p>Behind CourseCo is a team of dedicated professionals – developers, designers, methodologists, and instructors. We work together to create the best learning experience for our users, constantly improving the platform and expanding the course catalog.</p>

                    <div class="text-center mt-5">
                        <p>Join CourseCo today and start your journey to success!</p>
                        <a href="<?= $base_path ?>/templates/courses.php" class="btn btn-primary btn-lg">Start Learning</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 