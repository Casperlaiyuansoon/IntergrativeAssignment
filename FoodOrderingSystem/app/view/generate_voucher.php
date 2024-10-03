<?php
session_start();
include_once '../models/VoucherModel.php';
include_once '../models/PromotionModel.php'; // Include PromotionModel
include_once '../config/database.php';

// Database connection
$db = new Database();
$conn = $db->getConnection();
$voucherModel = new VoucherModel();
$promotionModel = new PromotionModel(); // Create an instance of PromotionModel
$today = date("Y-m-d");

// Check if there is an error message in the session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);  // Clear the error after displaying it

// Fetch promotions from the database
$promotions = $promotionModel->getAllPromotions(); // Assuming you have a method to get all promotions
?>

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
        input[type="text"], input[type="number"], input[type="date"], select {
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

   <!-- Display error message if exists -->
   <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="../controller/VoucherController.php">
        <label for="code">Voucher Code:</label>
        <input type="text" id="code" name="code" required>

        <label for="promotion_id">Promotion ID:</label>
        <select id="promotion_id" name="promotion_id" required>
            <option value="">Select a promotion</option>
            <?php foreach ($promotions as $promotion): ?>
                <option value="<?php echo $promotion['id']; ?>">
                    <?php echo htmlspecialchars($promotion['title']); ?> <!-- Adjust field name as necessary -->
                </option>
            <?php endforeach; ?>
        </select>

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required>

        <label for="discount_percentage">Discount Percentage:</label>
        <input type="number" id="discount_percentage" name="discount_percentage" step="0.01" required>

        <label for="max_uses">Maximum Uses:</label>
        <input type="number" id="max_uses" name="max_uses" value="1" required>

        <input type="submit" name="generate_voucher" value="Generate Voucher">
    </form>
    <a href="view_voucher.php" class="btn-back">Back</a>
</body>
</html>
