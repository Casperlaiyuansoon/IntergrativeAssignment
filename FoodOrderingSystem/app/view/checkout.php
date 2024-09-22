<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .checkout-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .checkout-form label, .checkout-form input {
            display: block;
            margin-bottom: 10px;
        }

        .checkout-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .checkout-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>
    
    <form method="POST" action="../controllers/CheckoutController.php" class="checkout-form">
        <label for="total_amount">Total Amount:</label>
        <input type="text" id="total_amount" name="total_amount" value="100.00" readonly>

        <label for="voucher_code">Voucher Code:</label>
        <input type="text" id="voucher_code" name="voucher_code" placeholder="Enter your voucher code">

        <input type="submit" name="apply_voucher" value="Apply Voucher">
    </form>

    <div id="message">
        <?php
        // Feedback will be displayed here based on controller logic
        ?>
    </div>
</body>
</html>
