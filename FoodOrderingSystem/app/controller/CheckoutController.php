<?php
include_once '../models/VoucherModel.php';  // Assuming you have a voucher model
include_once '../models/OrderModel.php';    // Assuming you have an order model
include_once '../db_config.php';  

if (isset($_POST['apply_voucher'])) {
    $voucher_code = $_POST['voucher_code'];
    $total_amount = (float)$_POST['total_amount'];

    // Call the function from the model to validate and fetch the voucher details
    $voucher = VoucherModel::getVoucherByCode($conn, $voucher_code);

    if ($voucher) {
        // Check if the voucher is valid (not expired, and has available uses)
        if ($voucher['expiration_date'] >= date('Y-m-d') && $voucher['times_used'] < $voucher['max_uses']) {
            // Calculate discount
            $discount_amount = $total_amount * ($voucher['discount_percentage'] / 100);
            $final_amount = $total_amount - $discount_amount;

            // Update the voucher usage count
            VoucherModel::incrementVoucherUsage($conn, $voucher['id']);

            // Save the order to the database
            OrderModel::saveOrder($conn, 1 /* customer_id */, $total_amount, $voucher_code, $discount_amount, $final_amount);

            // Success message
            echo "<p class='success'>Voucher applied successfully! You saved $" . number_format($discount_amount, 2) . ". Final amount: $" . number_format($final_amount, 2) . ".</p>";
        } else {
            // Voucher is invalid or expired
            echo "<p class='error'>Invalid or expired voucher code.</p>";
        }
    } else {
        // Voucher code not found
        echo "<p class='error'>Voucher code not found.</p>";
    }
}
?>
