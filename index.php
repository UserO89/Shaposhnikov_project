<?php
require_once __DIR__ . '/config/app.php'; // Включаем центральный файл конфигурации

require_once __DIR__ . '/Classes/Auth.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    header('Location: ' . BASE_PATH . '/templates/profile.php');
    exit();
} else {
    header('Location: ' . BASE_PATH . '/templates/home.php');
    exit();
}
