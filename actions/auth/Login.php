<?php
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Создаем экземпляр класса Auth
    $auth = new Auth();

    // Пытаемся выполнить вход
    $result = $auth->login($username, $password);

    if ($result) {
        // Успешный вход
        SessionMessage::set('success', 'Welcome! You have been successfully logged in.');
        header('Location: /Shaposhnikov_project/index.php');
        exit();
    } else {
        // Неудачный вход
        SessionMessage::set('danger', 'Invalid username or password.');
        header('Location: /Shaposhnikov_project/index.php');
        exit();
    }
} else {
    // Если запрос не POST, перенаправляем на главную
    header('Location: /index.php');
    exit();
}
