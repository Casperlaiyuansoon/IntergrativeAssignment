<?php

class DatabaseConnection {
    private static $instance = null;
    private $conn;

    private $host;
    private $username;
    private $password;
    private $database;

    // Constructor made private to prevent direct instantiation
    private function __construct() {
        // Retrieve credentials from environment variables for added security
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
        $this->database = getenv('DB_NAME') ?: 'promotion_system';

        // Create a connection using mysqli with error suppression
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check for connection errors and log them securely
        if ($this->conn->connect_error) {
            error_log("Database connection failed: " . $this->conn->connect_error); // Log the detailed error
            die("Unable to connect to the database. Please try again later."); // Generic error message
        }
    }

    // Singleton pattern to ensure only one instance of the database connection
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->conn;
    }
}
