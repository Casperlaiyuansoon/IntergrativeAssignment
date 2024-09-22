<?php
include_once '../config/userdatabase.php';
include_once '../proxy/UserActions.php';

class UserAdminManager implements UserActions
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Method to get all users
    public function getAllUsers()
    {
        try {
            $stmt = $this->conn->prepare("SELECT user_id, username, email, phone_number, createAt, status FROM user");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function getAllAdmins()
    {
        try {
            $stmt = $this->conn->prepare("SELECT admin_id, usernameAdmin, emailAdmin, phoneAdmin, createAt, role FROM admins");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching admins: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    // Method to search users by username
    public function searchUsers($query)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE username LIKE ?");
            $query = "%$query%";
            $stmt->bindParam(1, $query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error searching users: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    // Method to delete a user by ID
    public function deleteUser($user_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM user WHERE user_id = ?");
            $stmt->bindParam(1, $user_id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    // Method to search admins by username
    public function searchAdmins($query)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM admins WHERE usernameAdmin LIKE ?");
            $query = "%$query%";
            $stmt->bindParam(1, $query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error searching admins: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    // Method to delete an admin by ID
    public function deleteAdmin($admin_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM admins WHERE admin_id = ?");
            $stmt->bindParam(1, $admin_id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error deleting admin: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    // Add a new user
    public function addUser($username, $email, $phone_number, $password, $status)
    {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, email, phone_number, password, status, createAt) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $email, $phone_number, $hashed_password, $status]);
            return $stmt->rowCount() > 0; // Return true if a row was inserted
        } catch (Exception $e) {
            error_log("Error adding user: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function addAdmin($username, $email, $phone_number, $password, $role)
    {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admins (usernameAdmin, emailAdmin, phoneAdmin, passwordAdmin, role, createAt) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $email, $phone_number, $hashed_password, $role]);
            return $stmt->rowCount() > 0; // Return true if a row was inserted
        } catch (Exception $e) {
            error_log("Error adding admin: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM user WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user as an associative array
        } catch (Exception $e) {
            error_log("Error fetching user by ID: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function updateUser($id, $username, $email, $phone_number, $status)
    {
        try {
            $sql = "UPDATE user SET username = ?, email = ?, phone_number = ?, status = ? WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $email, $phone_number, $status, $id]); // Execute with an array of parameters
            return $stmt->rowCount() > 0; // Returns true if a row was updated
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function getAdminById($id)
    {
        try {
            $sql = "SELECT * FROM admins WHERE admin_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the admin as an associative array
        } catch (Exception $e) {
            error_log("Error fetching admin by ID: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }

    public function updateAdmin($id, $username, $email, $phone_number, $role)
    {
        try {
            $sql = "UPDATE admins SET usernameAdmin = ?, emailAdmin = ?, phoneAdmin = ?, role = ? WHERE admin_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $email, $phone_number, $role, $id]); // Execute with an array of parameters
            return $stmt->rowCount() > 0; // Returns true if a row was updated
        } catch (Exception $e) {
            error_log("Error updating admin: " . $e->getMessage());
            return false; // Or throw a custom exception
        }
    }
}
