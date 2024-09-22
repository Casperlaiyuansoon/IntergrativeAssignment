<?php
include_once '../commands/Command.php'; 
include_once '../models/NotificationModel.php';

class FetchNotificationCommand implements Command {
    private $notificationModel;
    private $customerId;

    public function __construct(NotificationModel $notificationModel, $customerId) {
        $this->notificationModel = $notificationModel;
        $this->customerId = $customerId;
    }

    public function execute() {
        return $this->notificationModel->getNotificationsByCustomerId($this->customerId);
    }
}
?>
