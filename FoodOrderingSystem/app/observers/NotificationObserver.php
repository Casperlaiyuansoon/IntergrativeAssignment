<?php

require_once 'Observer.php';

class NotificationObserver implements Observer {

    public function update($foodItem) {
        echo "Notification: A menu item was {$foodItem['action']}. ";
        if (isset($foodItem['image'])) {
            echo "Image: {$foodItem['image']} has been updated.";
        }
    }

}
