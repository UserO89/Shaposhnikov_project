<?php
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка, что скрипт запущен из командной строки
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from the command line');
}

// Данные администратора
$admin_data = [
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => 'your_secure_password_here', // Измените на реальный пароль
    'role' => 'admin'
];

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Проверяем, существует ли уже пользователь с таким username или email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$admin_data['username'], $admin_data['email']]);
    
    if ($stmt->fetchColumn() > 0) {
        echo "Admin user already exists!\n";
        exit(1);
    }

    // Хешируем пароль
    $hashed_password = password_hash($admin_data['password'], PASSWORD_DEFAULT);

    // Добавляем администратора
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $admin_data['username'],
        $admin_data['email'],
        $hashed_password,
        $admin_data['role']
    ]);

    echo "Admin user created successfully!\n";
    echo "Username: " . $admin_data['username'] . "\n";
    echo "Email: " . $admin_data['email'] . "\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?> 