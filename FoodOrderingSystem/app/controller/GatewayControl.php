<?php 
require_once "PaymentFactory.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/Payment.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/config/database.php";

$database = new Database();
// Get the database connection
$db = $database->getConnection();

$order = new Order($orderItemID = "", $orderID = "", $productName = "", $orderAmount = "", $orderQuantity = "", $orderTime = "");
$payment = new Payment($paymentID = "", $email = "", $totalAmount = "", $paymentAmount = "", $paymentGateway = "", $paymentDateTime = "");

if(isset($_GET['amount']) && isset($_GET['gateway']) && isset($_GET['time'])){
    $amount = $_GET['amount'];
    $paymentGateway = $_GET['gateway'];
    $paymentDateTime = $_GET['time'];

    $displayGateway = PaymentFactory::paymentGateway($paymentGateway);

}


$error = "";

if(isset($_POST['proceed-gateway'])){

    //CSRF Token Validation - Secure Coding Practice #1
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $cn = $_POST['cn'];
        $ce = $_POST['ce'];
        $cvv = $_POST['ccvv'];

        $sql = "SELECT CARDNUM, CARDEXP, CVV FROM PAYMENTMETHOD WHERE CARDNUM = '$cn'";
        $result = $db->query($sql);
        $result->execute();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){

            $dcn = $row['CARDNUM'];
            $dce = $row['CARDEXP'];
            $dcvv = $row['CVV'];
        } 
        
        if(!empty($cn) && !empty($ce) && !empty($cvv)){
            
            //Cross-Site Scripting (XSS) Protection - Secure Coding Practice #2
            $payment_data = [
            'CardNumber' => htmlspecialchars($cn, ENT_QUOTES, 'UTF-8'),
            'ExpiryDate' => htmlspecialchars($ce, ENT_QUOTES, 'UTF-8'),
            'CVV' => htmlspecialchars($cvv, ENT_QUOTES, 'UTF-8'),

            'DCN' => htmlspecialchars($dcn, ENT_QUOTES, 'UTF-8'),
            'DCE' => htmlspecialchars($dce, ENT_QUOTES, 'UTF-8'),
            'DCVV' => htmlspecialchars($dcvv, ENT_QUOTES, 'UTF-8'),
            ];
            
            // Initialize Session To Python Backend
            $url = 'http://localhost:5000/api/payment'; // Python API endpoint
            $ch = curl_init($url);
            
            // Set cURL Options
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL Request
            $response = curl_exec($ch);
            curl_close($ch);

            // Decode response from JSON to array
            $result = json_decode($response, true);

            // Display response
            $button = "";
            $paymentMessage = "";

            if ($result['status'] === 'success') {

                $paymentMessage = "<h3 style='color: darkgreen;'>Payment Successful: ". $result['message'] ."</h3>";
                echo $button = "";
                header("location: /FoodOrderingSystem/app/view/PaymentReceipt.php?message=". $paymentMessage);

            } else {

                $paymentMessage = "<h3 style='color: red;'>Payment Failed: ". $result['message'] ."</h3>";

                echo $button = "<div class='payment-button'>". 
                "<button type='button' class='b2' ><a href=''>Back To Payment Page</a></button></div>";

                header("location: /FoodOrderingSystem/app/view/PaymentReceipt.php?message=". $paymentMessage);
            }
        }

        else{
            $error = "Please enter card details";
        }
    }
    else {
        // CSRF token is invalid
        die("Invalid CSRF token");
    }
}

?>