<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/Payment.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/Order.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/VoucherModel.php";
require_once "PaymentFactory.php";
require "DBConfig.php";

date_default_timezone_set("Asia/Kuala_Lumpur");

$order = new Order($orderItemID = "", $orderID = "", $productName = "", $orderAmount = "", $orderQuantity = "", $orderTime = "");
$payment = new Payment($paymentID = "", $email = "", $totalAmount = "", $paymentAmount = "", $paymentGateway = "", $paymentDateTime = "");

//Initiate Session
session_start();
$email = $_SESSION['email'];

//Display Order Data
$sql = "SELECT O.ORDERID, O.ORDERITEMID, O.ORDERPRICE, O.ORDERQUANTITY, O.ORDERCREATION, O.PRODUCTID, P.ID, P.PRODUCTNAME FROM ORDERMAIN OM, ORDERITEM O, PRODUCT P WHERE O.PRODUCTID = P.ID AND OM.USEREMAIL = '$email' AND O.ORDERID = OM.ORDERID AND OM.ORDERSTATUS IS NULL";
$result = $db->query($sql);
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC)){

    $orderItemID = $row['ORDERITEMID'];
    $orderID = $row['ORDERID'];
    $productName = $row['PRODUCTNAME'];
    $orderPrice = $row['ORDERPRICE'];
    $orderQuantity = $row['ORDERQUANTITY'];
    $orderTime = $row['ORDERCREATION'];
    
    $orderArr[] = new Order($orderItemID, $orderID, $productName, $orderPrice, $orderQuantity, $orderTime);

    //echo "<p>". $row['ORDERID'], $row['PRODUCTNAME'], $row['ORDERPRICE'], $row['ORDERQUANTITY'] ."</p>";
} 


function displayOrder(){
    
    require "DBConfig.php";

    $email = $_SESSION['email'];

    $sql = "SELECT ORDERID, USEREMAIL FROM ORDERMAIN WHERE USEREMAIL = '$email' AND ORDERSTATUS IS NULL";
    $result = $db->query($sql);
    $result->execute();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $orderID = $row['ORDERID'];
    }

    return $orderID;
}

$subTotal = 0;
function subTotalCalculate($subTotal){

    require "DBConfig.php";

    $orderID =  displayOrder();

    $sql = "SELECT ORDERPRICE FROM ORDERITEM WHERE ORDERID = '$orderID'";
    $result = $db->query($sql);
    $result->execute();

    foreach($result as $itemPrice){

        $subTotal += $itemPrice['ORDERPRICE'];
    }

    return $subTotal;
}

function displayPaymentReceipt(){

    require "DBConfig.php";

    $email = $_SESSION['email'];
    //$email = "zhen@gmail.com";

    $sql2 = "SELECT PAYMENTID, USEREMAIL, TOTALAMOUNT, PAYMENTAMOUNT, PAYMENTMETHOD, PAYMENTTIME FROM PAYMENT WHERE USEREMAIL = '$email'";
    $result2 = $db->query($sql2);
    $result2->execute();

    while($row = $result2->fetch(PDO::FETCH_ASSOC)){

        $paymentID = $row['PAYMENTID'];
        $email = $row['USEREMAIL'];
        $totalAmount = $row['TOTALAMOUNT'];
        $paymentAmount = $row['PAYMENTAMOUNT'];
        $paymentGateway = $row['PAYMENTMETHOD'];
        $paymentDateTime = $row['PAYMENTTIME'];

        return $PaymentArr[] = new Payment($paymentID, $email, $totalAmount, $paymentAmount, $paymentGateway, $paymentDateTime);
    }

}

function updateOrder($orderAmount){

    require "DBConfig.php";
    $orderStatus = "SUCCESS";

    $orderID =  displayOrder();

    $sql3 = "UPDATE ORDERMAIN SET ORDERAMOUNT = ?, ORDERSTATUS = ? WHERE ORDERID = ?";
    $result3 = $db->prepare($sql3);
    $result3->bindParam(1, $orderAmount);
    $result3->bindParam(2, $orderStatus);
    $result3->bindParam(3, $orderID);

    $result3->execute();
}

function insertPayment(Payment $payment){

    require "DBConfig.php";

    $email = $_SESSION['email'];

    $sql1 = "INSERT INTO PAYMENT (USEREMAIL, TOTALAMOUNT, PAYMENTAMOUNT, PAYMENTMETHOD, PAYMENTTIME) VALUES (?, ?, ?, ?, ?)";
    $result1 = $db->prepare($sql1);
    $result1->bindParam(1, $email);
    $result1->bindParam(2, $payment->getTotal());
    $result1->bindParam(3, $payment->getPaymentAmount());
    $result1->bindParam(4, $payment->getPaymentMethod());
    $result1->bindParam(5, $payment->getPaymentTime());

    $result1->execute();
}

$Payment[] = displayPaymentReceipt();

$displaySubTotal = subTotalCalculate($subTotal);

$paymentFactory = new PaymentFactory();

if(isset($_POST['payment-checkout'])){

    $email = $_SESSION['email'];

    $totalAmount = $_POST['totalAmount'];
    $paymentAmount = $_POST['totalAmount'];
    $paymentGateway = $_POST['paymentgateway'];
    $paymentDateTime = date('Y-m-d H:i:s');

    $payment = PaymentFactory::createPayment($payment->setPayment($totalAmount, $paymentAmount, $paymentGateway, $paymentDateTime), "Insert");
    
    header("location: /FoodOrderingSystem/app/view/PaymentGatewayView.php?amount=". $paymentAmount ."&gateway=". $paymentGateway ."&time=". $paymentDateTime);

    //$order = PaymentFactory::createPayment($order->setOrderAmount($totalAmount), "Update");

}

function getVoucherAmount($code, $amount){

    require "DBConfig.php";

    $query = "SELECT * FROM VOUCHERS WHERE code = '$code'";
    $stmt = $db->prepare($query);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $amount = $row['DISCOUNT_PERCENTAGE'];
    }

    return $amount;

}

if(isset($_POST['post-voucher'])){

    $voucherCode = $_POST['promoCode'];

    $a = 0;
    $va = getVoucherAmount($voucherCode, $a);
    
    header("location: /FoodOrderingSystem/app/view/PaymentView.php");

    //$order = PaymentFactory::createPayment($order->setOrderAmount($totalAmount), "Update");

}

?>