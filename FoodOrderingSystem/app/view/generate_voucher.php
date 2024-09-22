<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Generate a New Voucher</h1>
    <form method="POST" action="../controllers/VoucherController.php">
        <label for="code">Voucher Code:</label>
        <input type="text" id="code" name="code" required>

        <label for="promotion_id">Promotion ID:</label>
        <input type="number" id="promotion_id" name="promotion_id" required>

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required>

        <label for="discount_percentage">Discount Percentage:</label>
        <input type="number" id="discount_percentage" name="discount_percentage" step="0.01" required>

        <label for="max_uses">Maximum Uses:</label>
        <input type="number" id="max_uses" name="max_uses" value="1" required>

        <input type="submit" name="generate_voucher" value="Generate Voucher">
    </form>
</body>
</html>
