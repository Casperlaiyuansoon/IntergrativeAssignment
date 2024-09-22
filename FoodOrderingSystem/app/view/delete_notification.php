<?php
include_once '../models/NotificationModel.php';
include_once '../models/DatabaseConnection.php';

// Set the header for JSON response
header('Content-Type: application/json');

// Retrieve and decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Check if `id` is set in the data
if (isset($data['id']) && is_numeric($data['id'])) {
    $conn = DatabaseConnection::getInstance();
    $notificationModel = new NotificationModel();

    // Attempt to delete the notification
    $result = $notificationModel->deleteNotification($data['id']);
    if ($result) {
        echo json_encode(["message" => "Notification deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete notification"]);
    }
} else {
    echo json_encode(["error" => "Invalid data"]);
}
?>
