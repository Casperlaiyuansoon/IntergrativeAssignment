<?php
include_once '../models/NotificationModel.php';
include_once '../config/database.php';

// Create a connection instance
$db = new Database();
$conn = $db->getConnection();
$notificationModel = new NotificationModel();

// Get the ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if ID is provided
if (!isset($_GET['id'])) {
    die('Notification ID not provided.');
}

$notificationId = $_GET['id'];

// Fetch the existing notification details
$notification = $notificationModel->getNotificationById($notificationId);

if (!$notification) {
    die('Notification not found.');
}

// Handle form submission to update the notification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $status = $_POST['status'];

    $updated = $notificationModel->updateNotification($notificationId, [
        'message' => $message,
        'status' => $status,
    ]);

    if ($updated) {
        echo "<script>alert('Notification updated successfully!'); window.location.href='view_notification.php';</script>";
    } else {
        echo "<script>alert('Failed to update notification.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .home-btn {
            background-color: #008CBA;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            display: block;
            margin-top: 15px;
        }
        .home-btn:hover {
            background-color: #007B9A;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Notification</h1>
        <form method="POST">
            <label for="message">Message:</label>
            <input type="text" name="message" id="message" value="<?php echo htmlspecialchars($notification['message']); ?>" required>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="sent" <?php if ($notification['status'] == 'sent') echo 'selected'; ?>>Active</option>
                <option value="pending" <?php if ($notification['status'] == 'pending') echo 'selected'; ?>>Pending</option>
            </select>

            <button type="submit">Update Notification</button>
        </form>
        <a href="homepage.php" class="home-btn">Home</a>
    </div>
</body>
</html>
