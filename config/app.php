<?php

// Настройки отображения ошибок
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/Shaposhnikov_project');
}

