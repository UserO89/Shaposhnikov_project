<?php

require_once __DIR__ . '/partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <link rel="icon" type="image/png" href="../assets/img/logo/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .thank-you-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .thank-you-container h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .thank-you-container p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .btn-back {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }

        .hero-section {
            background-image: url('../assets/img/banner.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .hero-section h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .hero-section p {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <?php if ($type === 'course_ordered'): ?>
            <h1>Thank You for Your Order!</h1>
            <p>Your course order has been successfully placed. We'll send you a confirmation email shortly with details on how to access your new course.</p>
            <p>Prepare for an exciting learning journey!</p>
        <?php elseif ($type === 'message_sent'): ?>
            <h1>Thank You for Your Message!</h1>
            <p>We have received your message and appreciate you reaching out. Our team will review your inquiry and get back to you as soon as possible.</p>
            <p>We look forward to connecting with you!</p>
        <?php else: ?>
            <h1>Thank You!</h1>
            <p>We appreciate your interaction with our site. Have a great day!</p>
        <?php endif; ?>
        <a href="/templates/home.php" class="btn btn-back">Go to Home Page</a>
    </div>
</body>
</html>
