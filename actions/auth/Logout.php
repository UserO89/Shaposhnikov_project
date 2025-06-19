<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../Classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    $auth->logout();
    header('Location:' . BASE_PATH . '/index.php');
    exit();
}
