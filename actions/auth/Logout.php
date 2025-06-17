<?php
require_once __DIR__ . '/../../Classes/Auth.php';

// Проверяем, что запрос пришел методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    $auth->logout();
    header('Location: /Shaposhnikov_project/index.php');
    exit();
}
