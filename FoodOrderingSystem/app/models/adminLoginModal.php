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
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $usernameAdmin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $this->admin_id = $admin['admin_id'];
            $this->usernameAdmin = $admin['usernameAdmin'];
            $this->passwordAdmin = $admin['passwordAdmin'];
            $this->role = $admin['role'];
            return true;
        }
        return false;
    }
}
