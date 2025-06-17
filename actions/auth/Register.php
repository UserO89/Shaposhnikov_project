<?php
session_start();
require_once '../../Classes/User.php';
require_once '../../Classes/Auth.php';
require_once '../../Classes/Validator.php';
require_once '../../Classes/SessionMessage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $auth = new Auth();
    $validator = new Validator();
    
    try {
        // Prepare user data
        $userData = [
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'role' => 'student'
        ];
        
        // Validate data
        if (!$validator->validateUserData($userData)) {
            throw new Exception($validator->getFirstError());
        }
        
        // Check password confirmation
        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Passwords do not match");
        }
        
        // Create user
        $userId = $user->create($userData);
        if (!$userId) {
            throw new Exception("Failed to create user - no ID returned");
        }
        
        // Login after registration
        $loginResult = $auth->login($userData['username'], $userData['password']);
        if (!$loginResult) {
            throw new Exception("Failed to login after registration");
        }
        
        SessionMessage::set('success', "Successful registration! Welcome to your account");
        header("Location: ../../index.php");
        exit();
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        SessionMessage::set('danger', $e->getMessage());
        header("Location: ../../index.php");
        exit();
    }
}
