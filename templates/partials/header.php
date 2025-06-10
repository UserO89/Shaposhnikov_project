<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="../assets/img/logo.png" alt="logo" class="navbar-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? ' active' : '' ?>" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'courses.php' ? ' active' : '' ?>" href="courses.php">Courses</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'NotFound.php' ? ' active' : '' ?>" href="NotFound.php">About</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? ' active' : '' ?>" href="contact.php">Contact</a></li>
      </ul>
      
      <!-- User section -->
      <div class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user'])): ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?php echo $base_path; ?>/templates/profile.php">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo $base_path; ?>/templates/logout.php">Logout</a></li>
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

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $base_path; ?>/templates/login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $base_path; ?>/templates/register.php" method="POST">
          <div class="mb-3">
            <label for="reg_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="reg_username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="reg_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="reg_email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="reg_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="reg_password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="reg_confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="reg_confirm_password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>