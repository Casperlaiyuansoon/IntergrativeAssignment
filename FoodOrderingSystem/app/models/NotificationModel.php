<?php
include_once 'BaseModel_roger.php';
include_once '../config/database.php';

class NotificationModel extends BaseModel_roger {
    protected $table = 'notifications';
    protected $usertable = 'user';
    

    // Create a new notification
    public function createNotification($data) {
        // Use prepared statements for secure database insertion
        $notificationId = $this->save($data);
        if ($notificationId) {
            return [
                'success' => true,
                'message' => 'Notification created successfully',
                'notification_id' => $notificationId
            ];
        } else {
            error_log("Failed to create notification: " . json_encode($data)); // Log failure for debugging
            return [
                'success' => false,
                'message' => 'Failed to create notification'
            ];
        }
    }

    // Fetch all notifications for a specific customer
    public function getNotificationsByCustomerId($customerId) {
        $query = "SELECT * FROM {$this->usertable} WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->conn->error); // Log preparation error
            return [
                'success' => false,
                'message' => 'Database error'
            ];
        }
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = $result->fetch_all(MYSQLI_ASSOC);

        if ($notifications) {
            return [
                'success' => true,
                'notifications' => $notifications
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No notifications found for this customer'
            ];
        }
    }

    // Update an existing notification
    public function updateNotification($data) {
        // Check if data contains necessary keys for update
        if (!isset($data['id'])) {
            error_log("Update failed: Missing notification ID"); // Log the error
            return [
                'success' => false,
                'message' => 'Notification ID is required for update'
            ];
        }

        $isUpdated = $this->save($data);
        if ($isUpdated) {
            return [
                'success' => true,
                'message' => 'Notification updated successfully'
            ];
        } else {
            error_log("Failed to update notification: " . json_encode($data)); // Log failure for debugging
            return [
                'success' => false,
                'message' => 'Failed to update notification'
            ];
        }
    }

    // Delete a notification by ID
    public function deleteNotification($id) {
        if (!is_numeric($id)) {
            error_log("Invalid notification ID provided for deletion: $id"); // Log invalid ID
            return [
                'success' => false,
                'message' => 'Invalid notification ID'
            ];
        }

        $isDeleted = $this->delete($id);
        if ($isDeleted) {
            return [
                'success' => true,
                'message' => 'Notification deleted successfully'
            ];
        } else {
            error_log("Failed to delete notification ID: $id"); // Log failure for debugging
            return [
                'success' => false,
                'message' => 'Failed to delete notification'
            ];
        }
    }

    // Fetch all notifications
    public function getAllNotifications() {
        try {
            return $this->findAll(); // Secure retrieval of all notifications
        } catch (Exception $e) {
            error_log("Error fetching all notifications: " . $e->getMessage()); // Log errors
            return [
                'success' => false,
                'message' => 'Failed to fetch notifications'
            ];
        }
    }
}
?>
