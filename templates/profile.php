<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/Database.php';
require_once __DIR__ . '/partials/header.php';

// Проверка, залогинен ли пользователь
$auth = new Auth();
$user = $auth->getUser();

if (!$user) {
    header('Location: /Shaposhnikov_project/templates/home.php');
    exit();
}

?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong> <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>"><?php echo ucfirst(htmlspecialchars($user['role'])); ?></span>
                    </div>
                    <div class="mb-3">
                        <strong>Registered On:</strong> <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                    </div>
                    <a href="#" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php';?> 