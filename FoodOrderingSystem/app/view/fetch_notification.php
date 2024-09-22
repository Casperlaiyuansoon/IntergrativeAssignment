<?php
include_once '../models/NotificationModel.php';
include_once '../commands/FetchNotificationCommand.php';
include_once '../commands/CommandInvoker.php';
include_once '../models/DatabaseConnection.php';

$conn = DatabaseConnection::getInstance();
$notificationModel = new NotificationModel();
$invoker = new CommandInvoker();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];

    $command = new FetchNotificationCommand($notificationModel, $customer_id);
    try {
        $notifications = $invoker->setCommand($command)->executeCommand();
        if ($notifications) {
            echo "<h2>Notifications:</h2>";
            foreach ($notifications as $notification) {
                echo "<div class='notification-item'>";
                echo "<p><strong>ID:</strong> " . htmlspecialchars($notification['id']) . "</p>";
                echo "<p><strong>Message:</strong> " . htmlspecialchars($notification['message']) . "</p>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($notification['status']) . "</p>";
                echo "<p><strong>Created At:</strong> " . htmlspecialchars($notification['created_at']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No notifications found.</p>";
        }
    } catch (Exception $e) {
        echo "<p>An error occurred: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Notifications</title>
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
        input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Button styling */
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Notification item styling */
        .notification-item {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
        }

        .notification-item p {
            margin: 5px 0;
        }

        .notification-item p strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Fetch Notifications</h1>
        <form method="POST" action="fetch_notification.php">
            <label for="customer_id">Customer ID:</label>
            <input type="number" name="customer_id" required><br>
            
            <input type="submit" value="Fetch Notifications">
        </form>
    </div>
</body>
</html>
