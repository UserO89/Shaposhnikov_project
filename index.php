<?php
session_start();
require_once __DIR__ . '/Classes/Auth.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    header('Location: /Shaposhnikov_project/templates/profile.php');
    exit();
} else {
    header('Location: /Shaposhnikov_project/templates/home.php');
    exit();
}
