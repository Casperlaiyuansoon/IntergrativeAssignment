<?php

require_once 'Observer.php';

class EmailNotificationObserver implements Observer {

    public function update($data) {

        echo "Email Observer: Food item updated with the following details: " . print_r($data, true);
    }

}
