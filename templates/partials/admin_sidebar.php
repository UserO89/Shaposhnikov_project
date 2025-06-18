<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? ' active text-white' : '' ?>" href="<?= BASE_PATH ?>/templates/admin/admin_dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'admin_users.php' ? ' active text-white' : '' ?>" href="<?= BASE_PATH ?>/templates/admin/admin_users.php">
                    <i class="fas fa-users me-2"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'admin_courses.php' ? ' active text-white' : '' ?>" href="<?= BASE_PATH ?>/templates/admin/admin_courses.php">
                    <i class="fas fa-book me-2"></i>
                    Courses
                </a>
            </li>
        </ul>
    </div>
</nav> 