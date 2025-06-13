<?php
session_start();
require_once '../../Classes/User.php';
require_once '../../Classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $auth = new Auth();
    
    try {
        // Проверяем, что все поля пришли
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || 
            empty($_POST['first_name']) || empty($_POST['last_name'])) {
            throw new Exception("All fields are required");
        }

        $userData = [
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'role' => 'student'
        ];
        
        // Проверяем совпадение паролей
        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Passwords do not match");
        }
        
        // Проверяем длину пароля
        if (strlen($_POST['password']) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }
        
        // Проверяем формат email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        
        // Пробуем создать пользователя
        try {
            $userId = $user->create($userData);
            if (!$userId) {
                throw new Exception("Failed to create user - no ID returned");
            }
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
        
        // Пробуем войти
        try {
            $loginResult = $auth->login($userData['username'], $userData['password']);
            if (!$loginResult) {
                throw new Exception("Failed to login after registration");
            }
        } catch (Exception $e) {
            throw new Exception("Error during login: " . $e->getMessage());
        }
        
        $_SESSION['success'] = "Succesful registration! Welcome to your account";
        header("Location: ../../index.php");
        exit();
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../../index.php");
        exit();
    }
}
