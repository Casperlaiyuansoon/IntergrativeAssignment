<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/Product.php";
//require_once "C:/xampp/htdocs/AssignmentFOS/MVC/Controller/CartItemfactory.php";
require "DBConfig.php";

//Initiate Session
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

$getEmail = $_SESSION['email'];
$product = new Product($id = "", $product = "", $image = "", $price = "", $description = "");

//Display Cart Data
$sql = "SELECT CM.USEREMAIL, C.CARTID, P.ID, P.PRODUCTNAME, P.IMAGE, C.CARTPRICE, C.CARTQUANTITY FROM CART CM, CARTITEM C, PRODUCT P WHERE P.ID = C.PRODUCTID AND CM.USEREMAIL = '$getEmail' AND C.CARTID = CM.CARTID";
$result = $db->query($sql);
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC)){

    $cartEmail = $row['USEREMAIL'];
    $cart = $row['CARTID'];
    $product = $row['ID'];
    $name = $row['PRODUCTNAME'];
    $image = $row['IMAGE'];
    $price = $row['CARTPRICE'];
    $quantity = $row['CARTQUANTITY'];
    
    $CartArr[] = new Cart($cart, $product, $name, $image, $price, $quantity);

    //echo "<p>". $row['CARTID'], $row['PRODUCTNAME'], $row['IMAGE'], $row['CARTPRICE'] ."</p>";
}   

//$cartFactory = new CartItemFactory();

if(isset($_GET['deleteID'])){

    $id = $_GET['deleteID'];
    deleteItem($id);
}

elseif(isset($_POST['checkout'])){

    insertOrder();
}

elseif(isset($_POST['clearcart'])){

    $cartData = displayCartUser();
    foreach($cartData as $c){
        $cID = $c['CARTID'];
    }

    clearCart($getEmail, $cID);
    header("location: /FoodOrderingSystem/Public/AddToCartView.php");
}

function displayCartUser(){
    
    require "DBConfig.php";

    $getEmail = $_SESSION['email'];

    $sql = "SELECT CM.USEREMAIL, C.CARTID, C.PRODUCTID, C.CARTPRICE, C.CARTQUANTITY FROM CARTITEM C, CART CM WHERE CM.USEREMAIL = '$getEmail' AND C.CARTID = CM.CARTID";
    $result = $db->query($sql);
    $result->execute();

    return $result;
}

function displayCartItem(){
    
    require "DBConfig.php";

    $getEmail = $_SESSION['email'];

    $sql = "SELECT CM.USEREMAIL, C.CARTID, C.PRODUCTID, C.CARTPRICE, C.CARTQUANTITY FROM CARTITEM C, CART CM WHERE CM.USEREMAIL = '$getEmail' AND C.CARTID = CM.CARTID";
    $result = $db->query($sql);
    $result->execute();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        
        $cart = $row['CARTID'];
        $product = $row['PRODUCTID'];
        $name = " ";
        $image = " ";
        $price = $row['CARTPRICE'];
        $quantity = $row['CARTQUANTITY'];

        $cartItemArr[] = new Cart($cart, $product, $name, $image, $price, $quantity);
    }

    return $cartItemArr;
}

function clearCart($getEmail, $getCart){

    require "DBConfig.php";

    $getEmail = $_SESSION['email'];
    
    $sql1 = "DELETE FROM CART WHERE USEREMAIL = '$getEmail'";
    $sql2 = "DELETE FROM CARTITEM WHERE CARTID = '$getCart'";
    $result1 = $db->prepare($sql1);
    $result2 = $db->prepare($sql2);

    $result1->execute();
    $result2->execute();

}

function deleteItem($getProductId){

    require "DBConfig.php";
    
    $cartData = displayCartUser();
    foreach($cartData as $c){
        $cID = $c['CARTID'];
    }

    $sql1 = "DELETE FROM CARTITEM WHERE PRODUCTID = ? AND CARTID = ?";
    $result1 = $db->prepare($sql1);
    $result1->bindParam(1, $getProductId);
    $result1->bindParam(2, $cID);

    $result1->execute();

    header("location: /FoodOrderingSystem/Public/AddToCartView.php");
}

function insertOrder(){

    require "DBConfig.php";

    $cartEmail = $_SESSION['email'];
    
    $sqlOrder = "SELECT ORDERID, USEREMAIL, ORDERSTATUS FROM ORDERMAIN WHERE USEREMAIL = '$cartEmail' AND ORDERSTATUS = NULL";
    $resultOrder = $db->query($sqlOrder);
    $resultOrder->execute();

    $dataRow = $resultOrder->rowCount();

    if($dataRow == 0){

        $orderTime = date('Y-m-d H:i:s');

        $sql3 = "INSERT INTO ORDERMAIN(USEREMAIL, ORDERCREATION) VALUES (?, ?)";
        $result3 = $db->prepare($sql3);
        $result3->bindParam(1, $cartEmail);
        $result3->bindParam(2, $orderTime);

        $result3->execute();

        $sqlOrder = "SELECT ORDERID, USEREMAIL, ORDERSTATUS FROM ORDERMAIN WHERE USEREMAIL = '$cartEmail' AND ORDERSTATUS IS NULL";
        $resultOrder = $db->query($sqlOrder);
        $resultOrder->execute();

        $cartData = displayCartUser();

        foreach($cartData as $c){
            $cID = $c['CARTID'];
        }

        foreach($_POST['orderquantity'] as $productID => $orderQuantity){
            $sqlUpdate = "UPDATE CARTITEM SET CARTQUANTITY = ? WHERE PRODUCTID = ? AND CARTID = ?";
            $resultUpdate = $db->prepare($sqlUpdate);
            $resultUpdate->bindParam(1, $orderQuantity);
            $resultUpdate->bindParam(2, $productID);
            $resultUpdate->bindParam(3, $cID);

            $resultUpdate->execute();   
        }
        
        while($row = $resultOrder->fetch(PDO::FETCH_ASSOC)){

            $orderID = $row['ORDERID'];
        }

        $cartItemArr = displayCartItem();

        foreach($cartItemArr as $cart){

            $orderTime = date('Y-m-d H:i:s');
            $productID = $cart->getProductId();
            $orderPrice = $cart->getPrice() * $cart->getQuantity();
            $orderQuantity = $cart->getQuantity();

            $sql2 = "INSERT INTO ORDERITEM (ORDERID, PRODUCTID, ORDERPRICE, ORDERQUANTITY, ORDERCREATION) VALUES (?, ?, ?, ?, ?)";
            $result2 = $db->prepare($sql2);
            $result2->bindParam(1, $orderID);
            $result2->bindParam(2, $productID);
            $result2->bindParam(3, $orderPrice);
            $result2->bindParam(4, $orderQuantity);
            $result2->bindParam(5, $orderTime);

            $result2->execute();
        }
        
        $cartData = displayCartUser();
        foreach($cartData as $c){
            $cID = $c['CARTID'];
        }
        clearCart($cartEmail, $cID);

        header("location: /FoodOrderingSystem/app/view/PaymentView.php");
    }

    else{

        while($row = $resultOrder->fetch(PDO::FETCH_ASSOC)){

            $orderID = $row['ORDERID'];
        }

        foreach($_POST['orderquantity'] as $productID => $orderQuantity){
            $sqlUpdate = "UPDATE CARTITEM SET CARTQUANTITY = ? WHERE PRODUCTID = ? AND CARTID = '$cart'";
            $resultUpdate = $db->prepare($sqlUpdate);
            $resultUpdate->bindParam(1, $orderQuantity);
            $resultUpdate->bindParam(2, $productID);

            $resultUpdate->execute();   
        }

        $cartItemArr = displayCartItem();

        foreach($cartItemArr as $cart){

            $orderTime = date('Y-m-d H:i:s');
            $productID = $cart->getProductId();
            $orderPrice = $cart->getPrice() * $cart->getQuantity();
            $orderQuantity = $cart->getQuantity();

            $sql2 = "INSERT INTO ORDERITEM (ORDERID, PRODUCTID, ORDERPRICE, ORDERQUANTITY, ORDERCREATION) VALUES (?, ?, ?, ?, ?)";
            $result2 = $db->prepare($sql2);
            $result2->bindParam(1, $orderID);
            $result2->bindParam(2, $productID);
            $result2->bindParam(3, $orderPrice);
            $result2->bindParam(4, $orderQuantity);
            $result2->bindParam(5, $orderTime);

            $result2->execute();
        }

        $cartData = displayCartUser();
        foreach($cartData as $c){
            $cID = $c['CARTID'];
        }
        clearCart($cartEmail, $cID);

        header("location: /FoodOrderingSystem/app/view/PaymentView.php");
    }
}

?>