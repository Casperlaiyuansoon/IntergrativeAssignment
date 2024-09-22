<?php
class User {
    private $conn;
    private $table_name = "user";

    public $user_id;
    public $username;
    public $password;
    public $status;
    public $email;

    // Constructor with Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Find user by username using PDO
    public function findByUsername($username) {
        $query = "SELECT user_id, username, password, status, email FROM " . $this->table_name . " WHERE username = :username";
        
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);
        
        // Bind the username to the query
        $stmt->bindValue(':username', $username);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the result as an associative array
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->user_id = $user['user_id'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->status = $user['status'];
            $this->email = $user['email'];
            return true;
        }
        return false;
    }
}
