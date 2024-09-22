<?php
include_once '../models/NotificationModel.php';

class SendNotificationCommand {
    private $notificationModel;
    private $customer_id;
    private $promotion_id;
    private $message;

    public function __construct($notificationModel, $customer_id, $promotion_id, $message) {
        $this->notificationModel = $notificationModel;
        $this->customer_id = $customer_id;
        $this->promotion_id = $promotion_id;
        $this->message = $message;
    }

    public function execute() {
        return $this->notificationModel->createNotification($this->customer_id, $this->promotion_id, $this->message);
    }
}
?>
