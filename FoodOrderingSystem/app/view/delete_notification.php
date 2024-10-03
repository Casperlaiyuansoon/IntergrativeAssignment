<?php
include_once '../models/NotificationModel.php';
include_once '../config/database.php';

// Create a connection instance
$db = new Database();
$conn = $db->getConnection();
$notificationModel = new NotificationModel();

// Check if ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notificationId = $_POST['id'];

    // Call the delete method
    $deleted = $notificationModel->deleteNotification($notificationId);

    if ($deleted) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
