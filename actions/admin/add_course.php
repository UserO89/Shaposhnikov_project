<?php
// Включаем отображение ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверяем, что сессия запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Определяем базовый путь
if (!isset($base_path)) {
    $base_path = '/Shaposhnikov_project'; 
}

require_once __DIR__ . '/../Classes/Auth.php';

// Проверка прав администратора
Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_file_path = __DIR__ . '/../assets/info.json';
    $courses = [];

    // Чтение существующих курсов
    if (file_exists($json_file_path)) {
        $json_content = file_get_contents($json_file_path);
        if ($json_content === false) {
            $_SESSION['errors'][] = 'Ошибка: Не удалось прочитать содержимое файла info.json.';
            header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
            exit();
        }
        $decoded_json = json_decode($json_content, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_json)) {
            $courses = $decoded_json;
        } else {
            $_SESSION['errors'][] = 'Ошибка: Некорректный формат JSON в файле info.json.';
            header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
            exit();
        }
    }

    // Получение данных из формы
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
    $image = trim($_POST['image'] ?? '');

    // Валидация данных
    $errors = [];
    if (empty($title)) {
        $errors[] = 'Название курса обязательно.';
    }
    if (empty($description)) {
        $errors[] = 'Описание курса обязательно.';
    }
    if (empty($duration)) {
        $errors[] = 'Продолжительность курса обязательна.';
    }
    if ($price === false || $price < 0) {
        $errors[] = 'Цена должна быть положительным числом.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
        exit();
    }

    // Генерация нового ID
    $new_id = 1;
    if (!empty($courses)) {
        $ids = array_column($courses, 'id');
        if (!empty($ids)) {
            $new_id = max($ids) + 1;
        } else {
            // If 'id' key is missing in some courses, generate a simple incrementing ID
            $new_id = count($courses) + 1;
        }
    }

    // Создание нового курса
    $new_course = [
        'id' => $new_id,
        'title' => $title,
        'description' => $description,
        'duration' => $duration,
        'price' => $price,
        'image' => $image
    ];

    // Добавление нового курса в массив
    $courses[] = $new_course;

    // Сохранение обновленного массива в JSON файл
    if (file_put_contents($json_file_path, json_encode($courses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        $_SESSION['success'] = 'Курс успешно добавлен.';
    } else {
        $_SESSION['errors'][] = 'Ошибка: Не удалось сохранить изменения в файле info.json.';
    }

    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
} else {
    // Если запрос не POST, перенаправляем на страницу курсов
    header('Location: ' . $base_path . '/templates/admin/admin_courses.php');
    exit();
}

?> 