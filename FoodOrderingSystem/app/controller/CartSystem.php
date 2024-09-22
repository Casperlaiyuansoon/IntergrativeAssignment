<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/CartFactoryInterface.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/view/ProductSample.php";
//require_once "C:/xampp/htdocs/AssignmentFOS/MVC/Controller/AddToCartControl.php";

class CartSystem implements CartFactoryInterface{

    private $data = [];

    public function __construct(){

    }

    public function addData($data){
        $this->data[] = $data;
        insertItem($data);
    }
    
    public function getData()
    {
        return $this->data;
    }

}
?>