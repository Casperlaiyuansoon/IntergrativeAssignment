<?php 
require_once "CartSystem.php";

class CartItemFactory{

    public static function createCart($data, $type) {

        if ($type == "Insert") {

            $cartSystem = new CartSystem();
            $cartSystem->addData($data);
        } 
        
        else {
            throw new Exception("Invalid");
        }
    }
}

?>