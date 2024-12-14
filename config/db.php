<?php
class db {
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $dsn = 'mysql:host=' . $_ENV['DB_SERVER'] . ';dbname=' . $_ENV['DB_DATABASE'];
        try {
            // Create a new PDO instance
            $this->pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}