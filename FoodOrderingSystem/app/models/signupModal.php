<?php
class User {
    private $conn;
    private $table = 'user';

    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $status = 'Inactive';
    public $createdAt;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new user
    public function create() {
        // Prepare an SQL statement to insert the data
        $sql = "INSERT INTO " . $this->table . " (email, username, password, phone_number, status, createAt) VALUES (:email, :username, :password, :phone_number, :status, NOW())";
        
        // Prepare the query
        $stmt = $this->conn->prepare($sql);
        
        // Hash the password before saving
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        // Bind parameters
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':status', $this->status);
        
        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Log the error if execution fails
            error_log('Execute failed: ' . $stmt->errorInfo()[2]);
            return false;
        }
    }
}
