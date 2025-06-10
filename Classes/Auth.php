<?php
require_once __DIR__ . '/Database.php';

class Auth extends Database
{
    private $user = null;

    public function __construct()
    {
        parent::__construct();
    }

    // Получить пользователя по данным сессии (и закэшировать)
    public function getUser()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        if (!isset($_SESSION['user']['id'])) {
            return null;
        }

        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        $this->user = $stmt->fetch();

        return $this->user;
    }

    // Проверка: авторизован ли пользователь
    public function isLoggedIn()
    {
        return $this->getUser() !== null;
    }

    // Проверка: есть ли определённая роль (универсальный метод)
    public function hasRole($role)
    {
        $user = $this->getUser();
        return $user && isset($user['role']) && $user['role'] === $role;
    }

    // Проверка: админ ли пользователь
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Пример метода для ограничения доступа (можно для любых ролей)
    public function requireRole($role)
    {
        if (!$this->hasRole($role)) {
            header('Location: /templates/404.php');
            exit();
        }
    }

    // Статический метод для быстрой проверки админа
    public static function requireAdmin()
    {
        $auth = new self();
        $auth->requireRole('admin');
    }

    public function login($username, $password)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            // Set user in session and return user data
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return $user;
        } else {
            return false; // Authentication failed
        }
    }
}
