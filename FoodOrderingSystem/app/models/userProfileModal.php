<?php
class User {
    private $conn;
    private $table = 'user';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch user data by user ID
    public function find($user_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update user profile information
    public function updateProfile($user_id, $phone_number) {
        $sql = "UPDATE " . $this->table . " SET phone_number = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $phone_number, $user_id);
        return $stmt->execute();
    }

    // Update user password
    public function updatePassword($user_id, $hashed_password) {
        $sql = "UPDATE " . $this->table . " SET password = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        return $stmt->execute();
    }
}
