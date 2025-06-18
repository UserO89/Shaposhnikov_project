<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/Course.php'; 

$user = null;
$activeCourses = [];
$errorMessage = null;

try {
    $auth = new Auth();
    $user = $auth->getUser();

    if (!$user) {
        header('Location: ' . BASE_PATH . '/templates/home.php');
        exit();
    }

    $courseObj = new Course(); 
    $activeCourses = $courseObj->getActiveCoursesByUserId($user['id']); 

} catch (Exception $e) {
    error_log("Error loading profile page: " . $e->getMessage());
    $errorMessage = "An error occurred while loading your profile. Please try again later.";
}
?>

<main class="container-fluid py-4">
    <?php renderFlashMessage();?>
    <h1 class="display-4 mb-4">My Profile</h1>
    
    <?php 
    if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <aside class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Profile Information</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                        <span class="badge bg-<?= ($user['role'] === 'admin') ? 'danger' : 'primary' ?>"><?= ucfirst(htmlspecialchars($user['role'])) ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Username</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['username']) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Member Since</label>
                        <p class="form-control-plaintext"><?= date('F d, Y', strtotime($user['created_at'])) ?></p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                        <form action="<?= BASE_PATH ?>/actions/auth/Logout.php" method="post">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                        <form action="<?= BASE_PATH ?>/actions/auth/delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            <button type="submit" class="btn btn-danger w-100 mt-2">
                                <i class="fas fa-trash-alt me-2"></i>Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <section class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">My Courses</h2>
                    <a href="<?= BASE_PATH ?>/templates/courses.php" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-2"></i>Browse Courses
                    </a>
                </div>
                <div class="card-body">

                    <?php if (!empty($activeCourses)): ?>
                    <div class="row g-4">
                        <?php foreach ($activeCourses as $course): ?>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <img src="<?= htmlspecialchars($course['image_url'] ?: BASE_PATH . '/assets/img/course-placeholder.jpg') ?>" class="card-img-top" alt="Course Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                    <a href="#" class="btn btn-primary">Continue Learning</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h5>No Active Courses</h5>
                        <p class="text-muted">Start your learning journey by enrolling in a course!</p>
                        <a href="<?= BASE_PATH ?>/templates/courses.php" class="btn btn-primary">
                            Browse Available Courses
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include_once __DIR__ . '/modals/auth/edit.php'; ?>
<?php require_once __DIR__ . '/partials/footer.php';?> 