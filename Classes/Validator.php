<?php
require_once __DIR__ . '/Database.php';

class Validator extends Database
{
    private $errors = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function validateUserData($data, $isUpdate = false)
    {
        $this->errors = [];

        if (empty($data['username'])) {
            $this->errors['username'] = 'Username is required';
        } elseif (strlen($data['username']) < 3) {
            $this->errors['username'] = 'Username must be at least 3 characters long';
        } elseif (strlen($data['username']) > 50) {
            $this->errors['username'] = 'Username must not exceed 50 characters';
        }

        if (empty($data['email'])) {
            $this->errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format';
        }

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = 'First name is required';
        } elseif (strlen($data['first_name']) > 50) {
            $this->errors['first_name'] = 'First name must not exceed 50 characters';
        }

        if (empty($data['last_name'])) {
            $this->errors['last_name'] = 'Last name is required';
        } elseif (strlen($data['last_name']) > 50) {
            $this->errors['last_name'] = 'Last name must not exceed 50 characters';
        }

        if (!$isUpdate || !empty($data['password'])) {
            if (empty($data['password'])) {
                $this->errors['password'] = 'Password is required';
            } elseif (strlen($data['password']) < 6) {
                $this->errors['password'] = 'Password must be at least 6 characters long';
            } elseif (strlen($data['password']) > 100) {
                $this->errors['password'] = 'Password must not exceed 100 characters';
            }
        }

        if (!empty($data['username']) || !empty($data['email'])) {
            $this->checkUniqueFields($data, $isUpdate);
        }

        return empty($this->errors);
    }

    private function checkUniqueFields($data, $isUpdate)
    {
        $conn = $this->getConnection();
        $userId = $isUpdate ? $data['id'] : null;

        if (!empty($data['username'])) {
            $sql = "SELECT id FROM users WHERE username = ?";
            $params = [$data['username']];
            
            if ($isUpdate) {
                $sql .= " AND id != ?";
                $params[] = $userId;
            }

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            
            if ($stmt->rowCount() > 0) {
                $this->errors['username'] = 'Username is already taken';
            }
        }

        if (!empty($data['email'])) {
            $sql = "SELECT id FROM users WHERE email = ?";
            $params = [$data['email']];
            
            if ($isUpdate) {
                $sql .= " AND id != ?";
                $params[] = $userId;
            }

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            
            if ($stmt->rowCount() > 0) {
                $this->errors['email'] = 'Email is already taken';
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFirstError()
    {
        return reset($this->errors);
    }
} 