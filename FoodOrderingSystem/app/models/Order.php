<?php 
require "C:/xampp/htdocs/FoodOrderingSystem/app/models/Cart.php";

class Order extends Cart{
    private $orderItemID;
    private $orderID;
    private $productName;
    private $orderPrice;
    private $orderQuantity;
    private $orderTime;

    public function __construct($orderItemID, $orderID, $productName, $orderPrice, $orderQuantity, $orderTime)
    {
        parent::__construct1($productName, $orderPrice);
        $this->orderItemID = $orderItemID;
        $this->orderID = $orderID;
        $this->orderQuantity = $orderQuantity;
        $this->orderTime = $orderTime;
    }

    public function __constructPayment($productName, $orderPrice, $orderQuantity)
    {
        parent::__construct1($productName, $orderPrice);
        $this->orderQuantity = $orderQuantity;
    }


    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }
    
    public function setOrderAmount($orderPrice){
        $this->orderPrice = $orderPrice;
        return $this->orderPrice;
    }

    public function getOrderItemId(){
        return $this->orderItemID;
    }

    public function getOrderId(){
        return $this->orderID;
    }

    public function getOrderQuantity(){
        return $this->orderQuantity;
    }

    public function getOrderTime(){
        return $this->orderTime;
    }
}