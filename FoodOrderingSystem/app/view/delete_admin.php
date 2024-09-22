<?php
session_start();
include_once '../models/UserAdminManager.php';
include_once '../proxy/UserProxy.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $admin_id = $_POST['id'];

    // Use UserProxy to delete the admin
    try {
        if ($proxy->deleteAdmin($admin_id)) { // Ensure deleteAdmin method exists in UserProxy
            echo "Admin deleted successfully";
        } else {
            echo "Failed to delete admin";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Handle any exceptions
    }
} else {
    echo "Invalid request";
}
