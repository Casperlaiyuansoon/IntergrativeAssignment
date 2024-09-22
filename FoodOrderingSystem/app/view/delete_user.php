<?php
session_start();
include_once '../models/UserAdminManager.php';
include_once '../proxy/UserProxy.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // Use UserProxy to delete the user
    try {
        if ($proxy->deleteUser($user_id)) { // Make sure deleteUser method exists in UserProxy
            echo "User deleted successfully";
        } else {
            echo "Failed to delete user";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Handle any exceptions
    }
} else {
    echo "Invalid request";
}
