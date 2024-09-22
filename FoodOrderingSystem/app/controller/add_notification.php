<!-- controllers/add_notification.php -->
<?php
include_once '../models/NotificationModel.php';
include_once '../models/DatabaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $customer_id = $_POST['customer_id'];
    $promotion_id = $_POST['promotion_id'];
    $message = $_POST['message'];

    // Get database connection
    $conn = DatabaseConnection::getInstance();

    // Create NotificationModel instance and add notification
    $notificationModel = new NotificationModel();
    $result = $notificationModel->createNotification($conn, $customer_id, $promotion_id, $message);

    if ($result) {
        echo "Notification created successfully!";
    } else {
        echo "Error creating notification.";
    }
} else {
    echo "Invalid request.";
}
?>
