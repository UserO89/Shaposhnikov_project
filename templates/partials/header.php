<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/Shaposhnikov_project/assets/img/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/Shaposhnikov_project/assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/Shaposhnikov_project/templates/home.php"><img src="/Shaposhnikov_project/assets/img/logo.png" alt="logo" class="navbar-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? ' active' : '' ?>" href="/Shaposhnikov_project/templates/home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'courses.php' ? ' active' : '' ?>" href="/Shaposhnikov_project/templates/courses.php">Courses</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'about.php' ? ' active' : '' ?>" href="/Shaposhnikov_project/templates/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? ' active' : '' ?>" href="/Shaposhnikov_project/templates/contact.php">Contact</a></li>
      </ul>
      
      <!-- User section -->
      <div class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user'])): ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/Shaposhnikov_project/templates/profile.php">Profile</a></li>
              <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/Shaposhnikov_project/templates/admin/admin_courses.php">Manage Courses</a></li>
                <li><a class="dropdown-item" href="/Shaposhnikov_project/templates/admin/admin_users.php">Manage Users</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="/Shaposhnikov_project/actions/user/Logout.php" method="POST" style="display: inline;">
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
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

<style>
.navbar {
  padding: 0.5rem 1rem;
  min-height: 60px;
}

.navbar-brand {
  padding: 0;
  display: flex;
  align-items: center;
}

.navbar-logo {
  height: 40px;
  width: auto;
  object-fit: contain;
}

.navbar-nav {
  align-items: center;
}

.nav-link {
  padding: 0.5rem 1rem;
}

.dropdown-menu {
  background-color: #343a40;
}

.dropdown-item {
  color: #fff;
}

.dropdown-item:hover {
  background-color: #495057;
  color: #fff;
}
</style>

<?php require_once __DIR__ . '/../modals/login_modal.php'?>
<?php require_once __DIR__ . '/../modals/register_modal.php'?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>