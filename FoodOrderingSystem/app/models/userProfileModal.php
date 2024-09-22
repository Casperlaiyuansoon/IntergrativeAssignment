<?php
class User {
    private $conn;
    private $table = 'user';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch user data by user ID
    public function find($user_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user profile information
    public function updateProfile($user_id, $phone_number) {
        $sql = "UPDATE " . $this->table . " SET phone_number = :phone_number WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update user password
    public function updatePassword($user_id, $hashed_password) {
        $sql = "UPDATE " . $this->table . " SET password = :password WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
