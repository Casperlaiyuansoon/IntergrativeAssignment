<?php
include_once 'models/NotificationModel.php';

class DeleteNotificationCommand implements Command {
    private $notificationModel;
    private $id;

    public function __construct(NotificationModel $notificationModel, $id) {
        $this->notificationModel = $notificationModel;
        $this->id = $id;
    }

    public function execute() {
        return $this->notificationModel->deleteNotification($this->id);
    }
}
?>
