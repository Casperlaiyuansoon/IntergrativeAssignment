<?php
include_once 'BaseModel_roger.php';
include_once '../config/database.php';

class NotificationModel extends BaseModel_roger {
    protected $table = 'notifications';
    protected $usertable = 'user';
    
    // Create a new notification
    public function createNotification($data) {
        // Use save method from BaseModel to handle insert
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
        // First, get the customer details
        $customerQuery = "SELECT * FROM user WHERE user_id = ?";
        $customerStmt = $this->conn->prepare($customerQuery);
        
        if (!$customerStmt) {
            error_log("SQL Prepare Error: " . implode(' ', $this->conn->errorInfo()));
            return [
                'success' => false,
                'message' => 'Database error'
            ];
        }
    
        $customerStmt->bindValue(1, $customerId, PDO::PARAM_INT);
        $customerStmt->execute();
        
        $customer = $customerStmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$customer) {
            return [
                'success' => false,
                'message' => 'Customer not found'
            ];
        }
    
        // Now retrieve notifications for this customer using a JOIN between users and notifications tables
        $query = "SELECT n.id, n.promotion_id, n.message, n.created_at, u.user_id 
                  FROM notifications n
                  JOIN user u ON n.user_id = u.user_id
                  WHERE u.user_id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . implode(' ', $this->conn->errorInfo()));
            return [
                'success' => false,
                'message' => 'Database error'
            ];
        }
    
        $stmt->bindValue(1, $customerId, PDO::PARAM_INT);
        $stmt->execute();
        
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($notifications) {
            return [
                'success' => true,
                'customer' => $customer,
                'notifications' => $notifications
            ];
        } else {
            return [
                'success' => true,
                'customer' => $customer,
                'notifications' => []
            ];
        }
    }

    public function getNotificationById($id) {
        $query = "SELECT * FROM notifications WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Return the notification data as an associative array
    }

    // Update an existing notification
    public function updateNotification($id, $data) {
        $query = "UPDATE notifications SET message = :message, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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

        // CHANGE: Delete using PDO
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
            // CHANGE: PDO for fetching all notifications
            return $this->findAll();
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
