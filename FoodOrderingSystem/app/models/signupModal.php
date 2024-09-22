<?php
class User {
    private $conn;
    private $table = 'user';

    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $status = 'Active';
    public $createdAt;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new user
    public function create() {
        // Prepare an SQL statement to insert the data
        $sql = "INSERT INTO " . $this->table . " (email, username, password, phone_number, status, createAt) VALUES (?, ?, ?, ?, ?, NOW())";
    
        // Prepare the query
        $stmt = $this->conn->prepare($sql);
    
        // Check if the statement preparation was successful
        if ($stmt === false) {
            error_log('Prepare failed: ' . $this->conn->error);
            return false;
        }
    
        // Hash the password before saving
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
    
        // Bind parameters
        $stmt->bind_param("sssss", $this->email, $this->username, $hashed_password, $this->phone_number, $this->status);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Log the error if execution fails
            error_log('Execute failed: ' . $stmt->error);
            return false;
        }
    }
    
}
