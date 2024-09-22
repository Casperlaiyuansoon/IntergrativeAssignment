<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/GatewayControl.php";
?>
<style>
    .form-group{
        display: grid;
        margin: 30px;
    }

    .card-detail{
        position: relative;
        display: inline-flex;
    }

    .payment-input{
        width: auto;
        margin: 10px;
        padding: 20px;
        display: grid;
        border: none;
        background: aliceblue;
        border-radius: 5px;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.7);
    }

    .payment-method {
        display: block;
        position: relative;
        width: 60%;
        border: 2px solid whitesmoke;
        border-radius: 6px;
        margin: auto;
        padding: 5px;
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.1);
    }

    .b1{
        padding: 10px;
        display: block;
        text-align: center;
        color: white;
        border-radius: 6px;
        background-color: aquamarine;
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
    
    <?= $error ?>
    <?= $displayGateway ?>
    
</body>