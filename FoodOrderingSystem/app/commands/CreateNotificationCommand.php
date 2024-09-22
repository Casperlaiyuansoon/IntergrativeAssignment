<?php
include_once 'Command.php'; 
include_once '../models/NotificationModel.php';

class CreateNotificationCommand implements Command {
    private $notificationModel;
    private $data;

    public function __construct(NotificationModel $notificationModel, array $data) {
        $this->notificationModel = $notificationModel;
        $this->data = $data;
    }

    public function execute() {
        return $this->notificationModel->createNotification($this->data);
    }
}
?>
