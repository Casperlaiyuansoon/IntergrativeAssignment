<?php

require_once 'Observer.php';  // Ensure that the Observer interface is included

class LoggingObserver implements Observer {

    public function update($foodItem) {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Action: {$foodItem['action']}, ";
        
        // Check if foodItem contains name and other details before logging
        if (isset($foodItem['name'])) {
            $logMessage .= "Food: {$foodItem['name']}, Price: {$foodItem['price']}, Image: {$foodItem['image']}\n";
        } else {
            $logMessage .= "Food ID: {$foodItem['id']}\n";
        }

        // Append the log message to the file 'food_log.txt'
        file_put_contents(__DIR__ . '/food_log.txt', $logMessage, FILE_APPEND);
    }

}
