<?php 

class Cart{
    private $cartID;
    private $productID;
    private $productName;
    private $image;
    private $cartPrice;
    private $quantity;

    public function __construct($cartID, $productID, $productName, $image, $price, $quantity)
    {
        $this->cartID = $cartID;
        $this->productID = $productID;
        $this->productName = $productName;
        $this->image = $image;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function __construct1($productName, $price)
    {
        $this->productName = $productName;
        $this->price = $price;
    }

    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function getCartId(){
        return $this->cartID;
    }

    public function getProductId(){
        return $this->productID;
    }

    public function getProductName(){
        return $this->productName;
    }

    public function getImage(){
        return $this->image;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getCartPrice(){
        return $this->cartPrice;
    }

    public function getQuantity(){
        return $this->quantity;
    }


    public function __toString()
    {
        return "Product: ". $this->product ."</br>". 
                "Price: ". $this->price ."</br>". 
                "Quantity: ". $this->quantity ."</br>";
    }
}
?>