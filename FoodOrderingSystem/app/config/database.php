<?php

class Database {
    private $host = 'localhost';
    private $dbName = 'foodorderingsystem';
    private $dbuser = 'root';
    private $dbpassword = '';

        public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->dbuser, $this->dbpassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

}
