<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Course.php';

$auth = new Auth();
Auth::requireAdmin(); // Ensure admin access

$course = new Course();

$courses = $course->getAll();
$categories = $course->getAllCategories(); // Fetch all categories

// Include header after all PHP operations
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                <li class="nav-item">
                        <a class="nav-link" href="/Shaposhnikov_project/templates/admin/admin_dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/Shaposhnikov_project/templates/admin/admin_users.php">
                            <i class="fas fa-users me-2"></i>
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="/Shaposhnikov_project/templates/admin/admin_courses.php">
                            <i class="fas fa-book me-2"></i>
                            Courses
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Course Management</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus"></i> Add Course
                </button>
            </div>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($courses as $course): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary"><?php echo htmlspecialchars($course['category'] ?? 'N/A'); ?></span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" onclick="editCourse(<?php echo htmlspecialchars(json_encode($course)); ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCourse(<?php echo $course['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add Course Modal -->
<?php require_once __DIR__ . '/../modals/add_course.php'; ?>

<!-- Edit Course Modal -->
<?php require_once __DIR__ . '/../modals/edit_course.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/Shaposhnikov_project/assets/js/admin_courses.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 