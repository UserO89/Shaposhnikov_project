<?php
session_start();

require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/User.php';

$auth = new Auth();
$user = new User();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  try {
    $loggedInUser = $auth->login($username, $password);
    if ($loggedInUser) {
      // Store necessary user info in session, not just password
      $_SESSION['user_id'] = $loggedInUser['id'];
      $_SESSION['username'] = $loggedInUser['username'];
      $_SESSION['role'] = $loggedInUser['role'];

      header('Location: home.php');
      exit();
    } else {
      $error = 'Invalid email or password';
    }
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - CourseCo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      max-width: 400px;
      width: 100%;
    }
    .btn-primary {
      background-color: #0056b3;
      border-color: #0056b3;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .logo {
      font-size: 1.8rem;
      font-weight: 700;
      color: #0056b3;
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card bg-white">
      <div class="logo">CourseCo</div>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>
      <form method="POST" action="">
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
</body>
</html>