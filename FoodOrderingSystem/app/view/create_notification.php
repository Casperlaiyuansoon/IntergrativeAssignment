<?php
include_once '../models/NotificationModel.php';
include_once '../commands/CreateNotificationCommand.php';
include_once '../commands/CommandInvoker.php';
include_once '../models/DatabaseConnection.php';

$conn = DatabaseConnection::getInstance();
$notificationModel = new NotificationModel();
$invoker = new CommandInvoker();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'customer_id' => $_POST['customer_id'],
        'promotion_id' => $_POST['promotion_id'],
        'message' => $_POST['message'],
        'status' => 'pending'
    ];

    $command = new CreateNotificationCommand($notificationModel, $data);
    try {
        $result = $invoker->setCommand($command)->executeCommand();
        if ($result) {
            echo "Notification created successfully!";
        } else {
            echo "Failed to create notification.";
        }
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Notification</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container for centering the form */
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Input and textarea styling */
        input[type="number"],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Button styling */
        input[type="submit"],
        .btn-back {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Notification</h1>
        <form method="POST" action="create_notification.php">
            <label for="customer_id">Customer ID:</label>
            <input type="number" name="customer_id" required><br>
            
            <label for="promotion_id">Promotion ID:</label>
            <input type="number" name="promotion_id" required><br>
            
            <label for="message">Message:</label>
            <textarea name="message" required></textarea><br>
            
            <input type="submit" value="Create Notification">
        </form>

        <!-- Back Button -->
        <div>
            <a href="view_notification.php" class="btn-back">Back to View Notifications</a>
        </div>
    </div>
</body>
</html>
