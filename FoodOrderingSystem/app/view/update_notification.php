<?php
include_once '../models/NotificationModel.php';
include_once '../models/DatabaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the notification ID from POST
    $notificationId = $_POST['id'];

    // Prepare the data for updating the notification
    $data = [
        'id' => $notificationId,
        'customer_id' => $_POST['customer_id'],
        'promotion_id' => $_POST['promotion_id'],
        'message' => $_POST['message'],
        'status' => $_POST['status']
    ];

    // Initialize the database connection and NotificationModel
    $conn = DatabaseConnection::getInstance();
    $notificationModel = new NotificationModel();

    // Call the update method on the NotificationModel
    $result = $notificationModel->updateNotification($data);

    // Return a response based on the result
    if ($result) {
        echo json_encode(["message" => "Notification updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update notification"]);
    }
}
?>
