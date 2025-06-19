<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../Classes/SessionMessage.php';
require_once __DIR__ . '/../../Classes/User.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $auth = new Auth();
    $validator = new Validator();
    
    try {
        $userData = [
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'role' => 'student'
        ];
        
        if (!$validator->validateUserData($userData)) {
            throw new Exception($validator->getFirstError());
        }
        
        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Passwords do not match");
        }
        
        $userId = $user->create($userData);
        if (!$userId) {
            throw new Exception("Failed to create user - no ID returned");
        }
        
        $loginResult = $auth->login($userData['username'], $userData['password']);
        if (!$loginResult) {
            throw new Exception("Failed to login after registration");
        }
        
        SessionMessage::set('success', "Successful registration! Welcome to your account");
        header("Location:" . BASE_PATH . "/index.php");
        exit();
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        SessionMessage::set('danger', $e->getMessage());
        header("Location:" . BASE_PATH . "/index.php");
        exit();
    }
}
