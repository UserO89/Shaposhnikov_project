<?php
require_once __DIR__ . '/Database.php';

class Auth extends Database
{
    private $user = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser()
    {
        if ($this->user !== null) {
            return $this->user;}
        if (!isset($_SESSION['user']['id'])) {
            return null;}
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        $this->user = $stmt->fetch();
        return $this->user;
    }

    public function isLoggedIn()
    {
        return $this->getUser() !== null;
    }

    public function hasRole($role)
    {
        $user = $this->getUser();
        return $user && isset($user['role']) && $user['role'] === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function requireRole($role)
    {
        if (!$this->hasRole($role)) {
            header('Location: /templates/NotFound.php');
            exit();}
    }

    public static function requireAdmin()
    {
        $auth = new self();
        $auth->requireRole('admin');
    }

    public function login($username, $password)
    {
        session_start();
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return $user;}
            else {
            return false;}
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        session_destroy();
    }
}
