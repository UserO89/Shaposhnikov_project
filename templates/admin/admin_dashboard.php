<?php
require_once __DIR__ . '/../../config/app.php'; // Include the central config file

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/User.php';
require_once __DIR__ . '/../../Classes/Course.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php'; // Add this line

$auth = new Auth();
Auth::requireAdmin();

$user = new User();
$course = new Course();

$totalUsers = $user->getCount();
$totalCourses = $course->getCount();
$usersLast30Days = $user->getUsersCountLast30Days();
$coursesLast30Days = $course->getCoursesCountLast30Days();
$recentUsers = $user->getRecentUsers(5); // Get last 5 registered users

require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="<?= BASE_PATH ?>/templates/admin/admin_dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= BASE_PATH ?>/templates/admin/admin_users.php">
                            <i class="fas fa-users me-2"></i>
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= BASE_PATH ?>/templates/admin/admin_courses.php">
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
                <h1 class="h2">Admin Dashboard</h1>
            </div>

            <?php
            if (SessionMessage::hasMessages()) {
                $message = SessionMessage::get();
                echo '<div class="alert alert-' . htmlspecialchars($message['type']) . ' alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($message['message']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            ?>

            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card text-center bg-primary text-white h-100 d-flex flex-column justify-content-center">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3 class="card-title display-4 fw-bold"><?php echo $totalUsers; ?></h3>
                            <p class="card-text fs-5">Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card text-center bg-success text-white h-100 d-flex flex-column justify-content-center">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <h3 class="card-title display-4 fw-bold"><?php echo $totalCourses; ?></h3>
                            <p class="card-text fs-5">Total Courses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card text-center bg-info text-white h-100 d-flex flex-column justify-content-center">
                        <div class="card-body">
                            <i class="fas fa-user-plus fa-3x mb-3"></i>
                            <h3 class="card-title display-4 fw-bold"><?php echo $usersLast30Days; ?></h3>
                            <p class="card-text fs-5">New Users (30 Days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card text-center bg-warning text-white h-100 d-flex flex-column justify-content-center">
                        <div class="card-body">
                            <i class="fas fa-book-medical fa-3x mb-3"></i>
                            <h3 class="card-title display-4 fw-bold"><?php echo $coursesLast30Days; ?></h3>
                            <p class="card-text fs-5">New Courses (30 Days)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Recent User Registrations</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentUsers)): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($recentUsers as $recentUser): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo htmlspecialchars($recentUser['username']); ?>
                                            <span class="badge bg-secondary rounded-pill"><?php echo date('M d, Y', strtotime($recentUser['created_at'])); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No recent user registrations to display.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= BASE_PATH ?>/templates/admin/admin_users.php" class="btn btn-primary btn-lg">
                                    <i class="fas fa-users-cog me-2"></i> Manage Users
                                </a>
                                <a href="<?= BASE_PATH ?>/templates/admin/admin_courses.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-book-open me-2"></i> Manage Courses
                                </a>
                                <button class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-user-plus me-2"></i> Add New User
                                </button>
                                <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                                    <i class="fas fa-folder-plus me-2"></i> Add New Course
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../modals/add_user.php'; ?>
<?php require_once __DIR__ . '/../modals/add_course.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 