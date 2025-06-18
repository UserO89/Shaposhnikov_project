<?php
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/User.php';
require_once __DIR__ . '/../../Classes/Course.php';

$auth = new Auth();
Auth::requireAdmin();

$user = new User();
$course = new Course();

$totalUsers = $user->getCount();
$totalCourses = $course->getCount();
$usersLast30Days = $user->getUsersCountLast30Days();
$coursesLast30Days = $course->getCoursesCountLast30Days();
$recentUsers = $user->getRecentUsers(5); 

require_once __DIR__ . '/../partials/renders.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../partials/admin_sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
            </div>

            <?php renderFlashMessage();  ?>

            <div class="row">
                <?php
                renderStatCard('fa-users', $totalUsers, 'Total Users', 'bg-primary');
                renderStatCard('fa-book', $totalCourses, 'Total Courses', 'bg-success');
                renderStatCard('fa-user-plus', $usersLast30Days, 'New Users (30 Days)', 'bg-info');
                renderStatCard('fa-book-medical', $coursesLast30Days, 'New Courses (30 Days)', 'bg-warning');
                ?>
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
                                            <?= htmlspecialchars($recentUser['username']); ?>
                                            <span class="badge bg-secondary rounded-pill"><?= date('M d, Y', strtotime($recentUser['created_at'])); ?></span>
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
<?php require_once __DIR__ . '/../modals/admin/add_user.php'; ?>
<?php require_once __DIR__ . '/../modals/admin/add_course.php'; ?>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 