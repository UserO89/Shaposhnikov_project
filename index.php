<?php
session_start();
require_once __DIR__ . '/Classes/Auth.php';

$auth = new Auth();

// Проверяем статус авторизации
if ($auth->isLoggedIn()) {
    // Если пользователь авторизован, перенаправляем на профиль
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();
} else {
    // Если пользователь не авторизован, перенаправляем на главную
    header('Location: /Shaposhnikov_project/templates/home.php');
    exit();
}
