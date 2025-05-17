<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assests/img/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assests/css/style.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="../assests/img/logo.png" alt="logo" class="navbar-logo"></a>
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
</style>

