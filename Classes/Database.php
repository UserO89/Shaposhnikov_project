<?php
require_once __DIR__ . '/DBInfo.php';

class Database {
    private $conn;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        $config = DBInfo::getConfig();
        
        try {
            $this->conn = new PDO(
                "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']}",
                $config['DB_USER'],
                $config['DB_PASS'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }
}
?>
