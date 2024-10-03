<?php
session_start();
include_once '../models/VoucherModel.php';
include_once '../config/database.php';

// Database connection
$db = new Database();
$conn = $db->getConnection();
$voucherModel = new VoucherModel();


if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

// Fetch the voucher ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $voucher = $voucherModel->getVoucherById($id);
    
    // Redirect if the voucher doesn't exist
    if (!$voucher) {
        $_SESSION['error'] = 'Voucher not found.';
        header("Location: view_voucher.php");
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid voucher ID.';
    header("Location: view_voucher.php");
    exit();
}

// Get today's date in the format "YYYY-MM-DD"
$today = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Voucher</h1>

    

    <form method="POST" action="../controller/VoucherController.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($voucher['id']); ?>">

        <label for="code">Code</label>
        <input type="text" name="code" id="code" value="<?php echo htmlspecialchars($voucher['code']); ?>" required>

        <label for="promotion_id">Promotion ID</label>
        <input type="number" name="promotion_id" id="promotion_id" value="<?php echo htmlspecialchars($voucher['promotion_id']); ?>" required>

        <label for="expiration_date">Expiration Date</label>
        <!-- Set today's date as the minimum selectable date -->
        <input type="date" name="expiration_date" id="expiration_date" min="<?php echo $today; ?>" value="<?php echo htmlspecialchars($voucher['expiration_date']); ?>" required>

        <label for="discount_percentage">Discount Percentage</label>
        <input type="number" name="discount_percentage" id="discount_percentage" value="<?php echo htmlspecialchars($voucher['discount_percentage']); ?>" required>

        <label for="max_uses">Max Uses</label>
        <input type="number" name="max_uses" id="max_uses" value="<?php echo htmlspecialchars($voucher['max_uses']); ?>" required>

        <label for="times_used">Times Used</label>
        <input type="number" name="times_used" id="times_used" value="<?php echo htmlspecialchars($voucher['times_used']); ?>" required>

        <input type="submit" name="edit_voucher" value="Update Voucher">
    </form>
</body>
</html>
