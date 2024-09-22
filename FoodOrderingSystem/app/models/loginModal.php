<?php
class User { 
    private $conn;
    private $table_name = "user";

    public $user_id;
    public $username;
    public $password;
    public $status;

    // Constructor with Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Find user by username
    public function findByUsername($username) {
        $query = "SELECT user_id, username, password, status FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->user_id = $user['user_id'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->status = $user['status'];
            return true;
        }
        return false;
    }
}
