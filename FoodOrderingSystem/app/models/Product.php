<?php 
require "Cart.php";

class Product extends Cart{

    private $id;
    private $image;
    private $description;
    private $quantity;

    public function __construct($id, $product, $image, $price, $description)
    {
        parent::__construct1($product, $price);
        $this->id = $id;
        $this->image = $image;
        $this->description = $description;
    }

    public function productInsert($id, $price, $quantity)
    {
        $this->id = $id;
        $this->price = $price;
        $this->quantity = $quantity;

        return $this;
    }

    public function __set($name, $value)
    {
        if(property_exists($this, $name)){
            $this->name = $value;
        }

        else{
            parent::__set($name, $value);
        }
    }

    public function __get($name)
    {
        if(property_exists($this, $name)){
            return $this->name;
        }

        else{
            return parent::__get($name);
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function getImage(){
        return $this->image;
    }

    public function getDescription(){
        return $this->description;
    }
}
?>