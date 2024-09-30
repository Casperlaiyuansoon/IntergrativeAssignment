<!DOCTYPE html>

<?php
require "C:/xampp/htdocs/FoodOrderingSystem/app/controller/PaymentControl.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/PaymentControl.php";
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    a{
        text-decoration: none;
        padding: 10px;
        display: block;
        color: #f6f9fc;
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

    input {
        padding: 10px 20px;
        outline: none;
        border: 1px solid #facc22;
        border-radius: 6px;
        color: #facc22;
    }

    .table_section {
        height: 650px;
        overflow: auto;
    }

    .form-header{
        align-items: left;
        padding: 10px;
        margin: auto;
        color: #8493a5;
    }

    .payment-view {
        margin: auto;
        padding: 10px;
        display:flex;
        position: fixed;
        overflow: auto;
    }

    .payment-method {
        display: block;
        position: relative;
        width: 40%;
        border: 2px solid whitesmoke;
        border-radius: 6px;
        margin: auto;
        padding: 20px;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.1);
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

    .b-voucher{
        padding: 10px 20px;
        display: block;
        text-align: center;
        color: white;
        background-color: chocolate;
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

    ::placeholder {
        color: #facc22;
    }

    .checkout-method{
        width: auto;
        float: left;
        display: grid;
        justify-content: left;
        margin: auto;
        padding: 10px;
    }

    .card{
        width: 500px;
    }

    .payment-input{
        width: auto;
        margin: 10px;
        padding: 20px;
        display: grid;
        border: none;
        background: aliceblue;
        border-radius: 20px;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.7);
    }

    .form-group{
        display: grid;
        margin: 30px;
    }

    .card-detail{
        position: relative;
        display: inline-flex;
    }

    .credit{
        background-color: white; 
        color: black; 
        border: 2px solid #ff5f5f;
    }

    .credit:hover{
        background-color: #ff5f5f;
        color: white;
    }

    .debit{
        background-color: white; 
        color: black; 
        border: 2px solid #008CBA;
    }

    .debit:hover{
        background-color: #008CBA;
        color: white;
    }

    .dx{
        background-color: white; 
        color: black; 
        border: 2px solid #af69ed;
    }

    .dx:hover{
        background-color: #af69ed;
        color: white;
    }

</style>

<head>
    <meta charset="UTF-8">
    <meta http-euiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="table">
        <div class="table_header">
            <p>Payment Checkout</p>
        </div>

        <div class="table_section">
            <div class="payment-view">

                <div class="payment-method">

                    <div class="form-header">
                        <h3>Payment Method</h3>
                    </div>

                    <form method="post" action="/FoodOrderingSystem/app/controller/PaymentControl.php">
                    <div class="checkout-method">

                        <input type="button" id="credit" class="card credit" onclick="paymentMethod('creditcard')" value="Credit Card" />
                        <input type="button" id="debit" class="card debit" onclick="paymentMethod('debitcard')" value="Debit Card" />
                        <!--<input type="button" id="dx" class="card dx" onclick="paymentMethod('dxbank')" value="DXBank" /> --->
                        <input type="hidden" id="payment-gateway" name="paymentgateway" value=""/>

                        <input type="text" id="payment-type" value="" readonly />

                    </div>
                
                </div>

                <div class="payment-details">

                    <div class="form-header">
                        <h3>Payment Details</h3>
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

                        <?php } ?>
                    </table>

                    <div class="payment-amount">

                        <div class="amount-list">
                            <h3>Sub-Total:</h3>
                            
                            <h3 class="charge">Service Charge:</h3>

                            <h3>
                                Apply Voucher Code: </br>
                                <input type="text" id="voucher" name="promoCode" />
                                <button type="submit" class="b-voucher" name="post-voucher" >Apply Code</button>
                            </h3>

                            <h3>Total:</h3>
                            
                        </div>

                        <div class="amount">
                            <h3 class="subtotal">0.00</h3>
                            <h3 class="servicecharge">0.00</h3>
                            <h3 class="vouchercode">0.00</h3></br></br></br>
                            <h3 class="total">0.00</h3>

                            <input type="hidden" class="paymentTotal" name="totalAmount" value="" />
                        </div>

                    </div>

                    <div class="payment-button">
                        <button type="submit" class="b1" name="payment-checkout">Payment Checkout</button></br>
                        <button type="submit" class="b2" name="payment-delete"><a href="/FoodOrderingSystem/app/view/homepage.php">Payment Cancel</a></button></a>
                    </div>
                </div>
                        </form>
        </div>
        </div>
    </div>

    <script>
        function paymentMethod(option) {
            //var creditCardInputs = document.getElementById('creditcard');
            //var debitCardInputs = document.getElementById('debitcard');
            //var dxBankInputs = document.getElementById('dxbank');
            //var paymentInputForm = document.getElementById('payment-input');
            var paymentGateway = document.getElementById('payment-gateway');
            var paymentType = document.getElementById('payment-type');

            if (option === 'creditcard') {

                /*
                creditCardInputs.style.display = 'grid';
                debitCardInputs.style.display = 'none';
                dxBankInputs.style.display = 'none';
                paymentInputForm.style.background = '#ff5f5f';
                */
               
                paymentGateway.value = "Credit Card";
                paymentType.value = "Credit Card";
            }

            else if (option === 'debitcard') {

                /*
                creditCardInputs.style.display = 'none';
                debitCardInputs.style.display = 'grid';
                dxBankInputs.style.display = 'none';
                paymentInputForm.style.background = '#008cba';
                */
               
                paymentGateway.value = "Debit Card";
                paymentType.value = "Debit Card";
            }

            /*
            else if (option === 'dxbank') {

                creditCardInputs.style.display = 'none';
                debitCardInputs.style.display = 'none';
                dxBankInputs.style.display = 'grid';
                paymentInputForm.style.background = '#af69ed';
                paymentGateway.value = "Online Banking";

                paymentType.value = "Online Banking";
                
            }
            */
        }

        <?php if(isset($_GET['voucher'])){

            $voucher = $_GET['voucher'];
        }
        
        else{
            $voucher = 0.00;
        }
        ?>

        function amountCalculation(){

            var subTotalValue = <?= $displaySubTotal ?>;
            var charge = 0.05;
            var voucherValue = <?= $voucher ?>;
            var totalValue = subTotalValue + (subTotalValue * charge) - voucherValue;

            const subTotal = document.querySelector('.subtotal');
            const chargeAmount = document.querySelector('.servicecharge');
            const voucherAmount = document.querySelector('.vouchercode');
            const total = document.querySelector('.total');

            const paymentTotal = document.querySelector('.paymentTotal');

            subTotal.innerText = subTotalValue.toFixed(2);
            chargeAmount.innerText = subTotalValue * charge.toFixed(2);
            voucherAmount.innerText = voucherValue.toFixed(2);
            total.innerText = totalValue.toFixed(2);

            paymentTotal.value = totalValue.toFixed(2);

            console.log(subTotal);
        }

        amountCalculation();
    </script>
</body>