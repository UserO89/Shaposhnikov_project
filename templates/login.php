<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=courseco;charset=utf8mb4';
$db_user = 'root';
$db_pass = '';

try {
  $pdo = new PDO($dsn, $db_user, $db_pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
} catch (PDOException $e) {
  die('Database connection failed: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['email'];
    header('Location: index.html');
    exit();
  } else {
    $error = 'Invalid email or password';
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
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required>
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