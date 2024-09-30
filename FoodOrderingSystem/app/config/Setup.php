<?php

namespace App\Config;

use PDO;
use PDOException;

class Setup {

    public static function getConnection() {
        $host = 'localhost';
        $dbName = 'foodorderingsystem';
        $dbuser = 'root';
        $dbpassword = '';

        function getConnection() {
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
}
    