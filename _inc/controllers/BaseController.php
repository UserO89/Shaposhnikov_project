<?php
class BaseController {
    protected $db;
    protected $view;

    public function __construct() {
        require_once __DIR__ . '/../config/Database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../templates/{$view}.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }
}
?> 