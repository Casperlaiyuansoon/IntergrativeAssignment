<?php
class User {
    private $conn;
    private $table_name = "admins";

    public $admin_id;
    public $usernameAdmin;
    public $passwordAdmin;
    public $role;

    // Constructor with Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Find user by username
    public function findByAdminname($usernameAdmin) {
        $query = "SELECT admin_id, usernameAdmin, passwordAdmin, role FROM " . $this->table_name . " WHERE usernameAdmin = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $usernameAdmin);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->admin_id = $result['admin_id'];
                $this->usernameAdmin = $result['usernameAdmin'];
                $this->passwordAdmin = $result['passwordAdmin'];
                $this->role = $result['role'];
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Error finding admin by username: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }
}
