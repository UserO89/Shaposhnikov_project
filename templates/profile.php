<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/Database.php';
require_once __DIR__ . '/partials/header.php';

$auth = new Auth();
$user = $auth->getUser();

if (!$user) {
    header('Location: /Shaposhnikov_project/templates/home.php');
    exit();
}

// Получение активных курсов пользователя
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT uc.progress, c.title, c.description, c.image_url 
                       FROM user_courses uc
                       JOIN courses c ON uc.course_id = c.id
                       WHERE uc.user_id = ? AND uc.is_completed = FALSE");
$stmt->execute([$user['id']]);
$activeCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="container-fluid py-4">
    <div class="row">
        <!-- Левая колонка с информацией профиля -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>"><?php echo ucfirst(htmlspecialchars($user['role'])); ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Username</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($user['username']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Member Since</label>
                        <p class="form-control-plaintext"><?php echo date('F d, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                        <form action="/Shaposhnikov_project/actions/user/Logout.php" method="post">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Правая колонка с активными курсами -->
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Courses</h4>
                    <a href="/Shaposhnikov_project/templates/courses.php" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-2"></i>Browse Courses
                    </a>
                </div>
                <div class="card-body">
                    <!-- Здесь будет список активных курсов -->
                    <?php if (!empty($activeCourses)): ?>
                    <div class="row g-4">
                        <?php foreach ($activeCourses as $course): ?>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <img src="<?php echo htmlspecialchars($course['image_url'] ?: '/Shaposhnikov_project/assets/img/course-placeholder.jpg'); ?>" class="card-img-top" alt="Course Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                                    <div class="progress mb-3">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo htmlspecialchars($course['progress']); ?>%" aria-valuenow="<?php echo htmlspecialchars($course['progress']); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo htmlspecialchars($course['progress']); ?>% Complete</div>
                                    </div>
                                    <a href="#" class="btn btn-primary">Continue Learning</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <!-- Если нет активных курсов -->
                    <div class="text-center py-5">
                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h5>No Active Courses</h5>
                        <p class="text-muted">Start your learning journey by enrolling in a course!</p>
                        <a href="/Shaposhnikov_project/templates/courses.php" class="btn btn-primary">
                            Browse Available Courses
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.form-control-plaintext {
    font-weight: 500;
    padding: 0.375rem 0;
}

.progress {
    height: 8px;
    border-radius: 4px;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.btn {
    border-radius: 5px;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5em 1em;
}
</style>

<?php include_once __DIR__ . '/modals/edit_modal.php'; ?>
<?php require_once __DIR__ . '/partials/footer.php';?> 