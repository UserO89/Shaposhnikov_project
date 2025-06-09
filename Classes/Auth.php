<?php
class Auth
{
    private $db;           
    private $user = null;  

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
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

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
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
}
