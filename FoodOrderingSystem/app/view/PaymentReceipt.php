<!DOCTYPE html>

<?php
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/PaymentControl.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/GatewayControl.php";

/*
require("C:/xampp/htdocs/AssignmentFOS/MVC/Controller/fpdf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font for the document
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');

    // Line break
    $pdf->Ln(10);

    foreach($Payment as $payment){ 
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, 'Receipt Number:', 0, 0);
        $pdf->Cell(50, 10, $payment->getPaymentId(), 0, 1);

        $pdf->Cell(50, 10, 'Payment Date:', 0, 0);
        $pdf->Cell(50, 10, $payment->getPaymentTime(), 0, 1);

        $pdf->Cell(50, 10, 'Payer Name:', 0, 0);
        $pdf->Cell(50, 10, $payment->getUserEmail(), 0, 1);

        $pdf->Cell(50, 10, 'Amount Paid:', 0, 0);
        $pdf->Cell(50, 10, '$' . $payment->getPaymentAmount(), 0, 1);

        $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
        $pdf->Cell(50, 10, $payment->getPaymentMethod(), 0, 1);
    }
    // Output the PDF as a downloadable file
    $pdf->Output('D', 'Payment_Receipt.pdf');
}
*/
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    a{
        text-decoration: none;
        padding: 10px;
        display: block;
        color:#f6f9fc;
    }

    .table {
        width: 100%;
        height: 80%;
    }

    .table_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: rgb(240, 240, 240);
    }

    .table_header p {
        color: #000000;
    }

    button {
        outline: none;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        padding: 10px;
        color: #ffffff;
    }

    td button:nth-child(1) {
        background-color: #f80000;
    }

    .payment-amount {
        display: flex;
        border: 2px solid whitesmoke;
        border-radius: 6px;
        background-color: white;
        margin: auto;
        padding: 20px;
    }

    .amount-list {
        display: block;
    }

    .payment-details {
        display: block;
        width: 58%;
        height: 650px;
        background-color:mintcream;
        border: 2px solid whitesmoke;
        border-radius: 6px;
        margin: auto;
        padding: 20px;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.1);
        overflow: scroll;
    }

    .amount h3{
        margin-left: 370px;
    }

    h3{
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    thead th {
        position: sticky;
        top: 0;
        background-color: #f6f9fc;
        color: #8493a5;
        font-size: 15px;
    }

    th,
    td {
        border-bottom: 1px solid #dddddd;
        background-color: #ffffff;
        padding: 10px 20px;
        word-break: break-all;
        text-align: center;
    }

    td img {
        height: 60px;
        width: 60px;
        object-fit: cover;
        border-radius: 15px;
        border: 5px solid #ced0d2;
    }

    tr:hover td {
        color: #0298cf;
        cursor: pointer;
        background-color: #f6f9fc;
    }

    .payment-button {
        display: grid;
        margin: auto;
        padding: 10px;
        position: relative;
    }

    .b1,
    .b2 {
        padding: 10px;
        display: block;
        text-align: center;
        color: white;
        border-radius: 6px;
    }

    .b1 {
        background-color: aquamarine;
    }

    .b2 {
        background-color: brown;
    }
</style>
<body>

<form method="post" action='<?php $_SERVER['PHP_SELF'] ?>'>
<div class="payment-details">

                    <div class="form-header">
                        <h3>Payment Receipt</h3>

                        <?php if(isset($_GET['message'])){
                            echo $_GET['message'];
                        } ?>

                        <?php foreach($Payment as $payment){ ?>

                            <h3>Payment ID: <?= $payment->getPaymentId() ?></h3>
                            <h3>User: <?= $payment->getUserEmail() ?></h3>

                        <?php } ?>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Order Food</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach($orderArr as $order){ ?>
                            <tr>
                                <td><?= $order->getOrderQuantity() ?></td>
                                <td><?= $order->getProductName() ?></td>
                                <td><?= $order->getPrice() ?></td>
                            </tr>
                        </tbody>

                        <?php $order = PaymentFactory::createPayment($order->setOrderAmount($order->getPrice()), "Update"); } ?>
                    </table>

                    <div class="payment-amount">

                        <div class="amount-list">
                            <h3>Sub-Total:</h3>
                            
                            <h3>Service Charge:</h3>

                            <h3 style="border-bottom: 2px black;">Total:</h3></br>

                            <h3>Payment Amount:</h3>

                            <h3>Payment Method:</h3>

                            <h3>Payment Time:</h3>
                            
                        </div>

                        <div class="amount">

                            <h3 class="subtotal">0.00</h3>
                            <h3 class="servicecharge">0.00</h3>
                            <h3 class="total">0.00</h3></br>

                            <?php foreach($Payment as $payment){ ?>

                                <h3><?= $payment->getPaymentAmount() ?></h3>

                                <h3><?= $payment->getPaymentMethod() ?></h3>

                                <h3><?= $payment->getPaymentTime() ?></h3>

                                
                            <?php } ?>
                        </div>

                    </div>

                    <div class='payment-button'>
                    <button type='button' class='b1' ><a href='/FoodOrderingSystem/Public/homepage.php'>Payment Completed</a></button></br>
                    <!-- <button type='submit' class='b1' name='generate' >Download Receipt</button></br> -->
                    </div>

                </div>
</form>
</body>

<script>
    function amountCalculation(){

        var subTotalValue = <?= $displaySubTotal ?>;
        var charge = 0.05;
        var totalValue = subTotalValue + (subTotalValue * charge);

        const subTotal = document.querySelector('.subtotal');
        const chargeAmount = document.querySelector('.servicecharge');
        const total = document.querySelector('.total');

        subTotal.innerText = subTotalValue.toFixed(2);
        chargeAmount.innerText = subTotalValue * charge.toFixed(2);
        total.innerText = totalValue.toFixed(2);

        paymentTotal.value = totalValue.toFixed(2);

        console.log(subTotal);
    }

    amountCalculation();
</script>