<?php
session_start();
include_once '../models/NotificationModel.php';
include_once '../commands/CreateNotificationCommand.php';
include_once '../commands/ReadNotificationCommand.php';
include_once '../commands/UpdateNotificationCommand.php';
include_once '../commands/DeleteNotificationCommand.php';
include_once '../commands/CommandInvoker.php';

// Database connection
$conn = DatabaseConnection::getInstance();
$notificationModel = new NotificationModel();

// Function to handle the creation of notifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_notification'])) {
    $data = [
        'customer_id' => $_POST['customer_id'],
        'promotion_id' => $_POST['promotion_id'],
        'message' => $_POST['message'],
        'status' => 'pending'
    ];

    $command = new CreateNotificationCommand($notificationModel, $data);
    $invoker = new CommandInvoker();
    try {
        $result = $invoker->setCommand($command)->executeCommand();
        if ($result) {
            echo "Notification created successfully.";
        } else {
            echo "Failed to create notification.";
        }
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}


// Function to handle fetching notifications
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_notifications'])) {
    $customerId = $_GET['customer_id'];
    $command = new ReadNotificationCommand($notificationModel, $customerId);
    $invoker = new CommandInvoker();
    try {
        $notifications = $invoker->setCommand($command)->executeCommand();
        foreach ($notifications as $notification) {
            echo "<p>Notification ID: {$notification['id']}, Message: {$notification['message']}</p>";
        }
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
    
    
    
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['view_notifications'])) {
    $customerId = $_SESSION['customer_id']; // Assuming customer_id is stored in session after login

    $command = new ReadNotificationCommand($notificationModel, $customerId);
    $invoker = new CommandInvoker();
    try {
        $notifications = $invoker->setCommand($command)->executeCommand();
        foreach ($notifications as $notification) {
            echo "<p>Notification ID: {$notification['id']}, Message: {$notification['message']}</p>";
        }
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}
}
?>
