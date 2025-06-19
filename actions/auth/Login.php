<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../Classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $auth = new Auth();
    $result = $auth->login($username, $password);

    if ($result) {
        SessionMessage::set('success', 'Welcome! You have been successfully logged in.');
        header('Location:' . BASE_PATH . '/index.php');
        exit();
    } else {
        SessionMessage::set('danger', 'Invalid username or password.');
        header('Location:' . BASE_PATH . '/index.php');
        exit();
    }
} else {
    header('Location: /index.php');
    exit();
}
