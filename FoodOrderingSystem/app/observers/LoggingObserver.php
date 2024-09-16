<?php

require_once 'Observer.php';

class LoggingObserver implements Observer {

    public function update($data) {

        file_put_contents('food_log.txt', "Food item updated: " . print_r($data, true) . "\n", FILE_APPEND);
    }

}
