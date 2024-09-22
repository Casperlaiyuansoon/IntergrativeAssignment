<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/model/CartFactoryInterface.php";
require_once "PaymentControl.php";

class OrderSystem{

    private $information;

    public function __construct()
    {

    }

    public function update($item)
    {
        updateOrder($item);
    }

    public function getInformation(){

        return $this->information;
    }

}
?>