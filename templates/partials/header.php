<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';
require_once __DIR__ . '/renders.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?= BASE_PATH ?>/assets/img/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
  <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_PATH ?>/templates/home.php"><img src="<?= BASE_PATH ?>/assets/img/logo.png" alt="logo" class="navbar-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? ' active' : '' ?>" href="<?= BASE_PATH ?>/templates/home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'courses.php' ? ' active' : '' ?>" href="<?= BASE_PATH ?>/templates/courses.php">Courses</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'about.php' ? ' active' : '' ?>" href="<?= BASE_PATH ?>/templates/about.php">About</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? ' active' : '' ?>" href="<?= BASE_PATH ?>/templates/profile.php">Profile</a>
            </li>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_PATH ?>/templates/admin/admin_dashboard.php">Admin</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
      </ul>
      
      <div class="navbar-nav">
        <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <span class="nav-link text-light"><?= htmlspecialchars($_SESSION['user']['username']); ?></span>
            </li>
            <li class="nav-item">
                <form action="<?= BASE_PATH ?>/actions/auth/Logout.php" method="POST">
                    <button type="submit" class="nav-link logout-link">Logout</button>
                </form>
            </li>
        <?php else: ?>
          <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
          </button>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
            Register
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<?php require_once __DIR__ . '/../modals/auth/login_modal.php'?>
<?php require_once __DIR__ . '/../modals/auth/register_modal.php'?>
