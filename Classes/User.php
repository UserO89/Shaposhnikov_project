<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Validator.php';

class User extends Database
{
    private $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new Validator();
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
            if (!$this->validator->validateUserData($data)) {
                throw new Exception($this->validator->getFirstError());
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
                $data['role'] ?? 'student'
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
            // Добавляем ID в данные для валидации
            $data['id'] = $id;

            // Валидация данных
            if (!$this->validator->validateUserData($data, true)) {
                throw new Exception($this->validator->getFirstError());
            }

            // Проверка существования пользователя
            $user = $this->getById($id);
            if (!$user) {
                throw new Exception('User not found');
            }

            // Подготовка данных для обновления
            $updateData = [
                'username' => $data['username'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email']
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

    // Получить последних N пользователей
    public function getRecentUsers($limit = 5)
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить количество пользователей, зарегистрированных за последние 30 дней
    public function getUsersCountLast30Days()
    {
        $sql = "SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $stmt = $this->getConnection()->query($sql);
        return $stmt->fetchColumn();
    }
}
