<?php
require_once __DIR__ . '/Database.php';

class User extends Database
{
    private $id;
    private $username;
    private $first_name;
    private $last_name;
    private $email;
    private $role;
    private $password;
    private $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    // Получить пользователя по ID
    public function getById($id)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить пользователя по email
    public function getByEmail($email)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить пользователя по username
    public function getByUsername($username)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить всех пользователей
    public function getAll()
    {
        $stmt = $this->getConnection()->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Создать нового пользователя
    public function create($data)
    {
        try {
            // Валидация данных
            $this->validateUserData($data);

            // Проверка на существующий email
            if ($this->getByEmail($data['email'])) {
                throw new Exception('Email already exists');
            }

            // Проверка на существующий username
            if ($this->getByUsername($data['username'])) {
                throw new Exception('Username already exists');
            }

            // Хеширование пароля
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

            // Подготовка SQL запроса
            $sql = "INSERT INTO users (username, first_name, last_name, email, password, role, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                $data['username'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $hashed_password,
                $data['role'] ?? 'user'
            ]);

            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Error creating user: ' . $e->getMessage());
        }
    }

    // Обновить данные пользователя
    public function update($id, $data)
    {
        try {
            // Валидация данных
            $this->validateUserData($data, true);

            // Проверка существования пользователя
            $user = $this->getById($id);
            if (!$user) {
                throw new Exception('User not found');
            }

            // Проверка на существующий email (исключая текущего пользователя)
            $existingUser = $this->getByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $id) {
                throw new Exception('Email already exists');
            }

            // Проверка на существующий username (исключая текущего пользователя)
            $existingUser = $this->getByUsername($data['username']);
            if ($existingUser && $existingUser['id'] != $id) {
                throw new Exception('Username already exists');
            }

            // Подготовка данных для обновления
            $updateData = [
                'username' => $data['username'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role' => $data['role']
            ];

            // Если указан новый пароль, добавляем его в обновление
            if (!empty($data['password'])) {
                $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            // Формирование SQL запроса
            $sql = "UPDATE users SET ";
            $params = [];
            foreach ($updateData as $key => $value) {
                $sql .= "$key = ?, ";
                $params[] = $value;
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = ?";
            $params[] = $id;

            // Выполнение запроса
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);

            return true;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

    // Удалить пользователя
    public function delete($id)
    {
        try {
            $stmt = $this->getConnection()->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            throw new Exception('Error deleting user: ' . $e->getMessage());
        }
    }

    // Валидация данных пользователя
    private function validateUserData($data, $isUpdate = false)
    {
        $errors = [];

        // Проверка обязательных полей
        if (empty($data['username'])) {
            $errors[] = 'Username is required';
        }
        if (empty($data['first_name'])) {
            $errors[] = 'First name is required';
        }
        if (empty($data['last_name'])) {
            $errors[] = 'Last name is required';
        }
        if (empty($data['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // Проверка пароля (только для создания или если указан при обновлении)
        if (!$isUpdate || !empty($data['password'])) {
            if (empty($data['password'])) {
                $errors[] = 'Password is required';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'Password must be at least 6 characters long';
            }
        }

        // Проверка роли
        if (isset($data['role']) && !in_array($data['role'], ['user', 'admin'])) {
            $errors[] = 'Invalid role';
        }

        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
    }

    // Поиск пользователей
    public function search($query)
    {
        $search = "%$query%";
        $sql = "SELECT * FROM users 
                WHERE username LIKE ? 
                OR first_name LIKE ? 
                OR last_name LIKE ? 
                OR email LIKE ? 
                ORDER BY created_at DESC";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$search, $search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить количество пользователей
    public function getCount()
    {
        $stmt = $this->getConnection()->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    // Получить пользователей с пагинацией
    public function getPaginated($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
