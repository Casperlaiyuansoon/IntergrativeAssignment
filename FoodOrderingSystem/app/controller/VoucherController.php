<?php
session_start();
include_once '../models/VoucherModel.php';
include_once '../models/DatabaseConnection.php';
include_once '../commands/Command.php';
include_once '../commands/GenerateVoucherCommand.php';
include_once '../commands/CommandInvoker.php';

// Database connection
$conn = DatabaseConnection::getInstance();
$voucherModel = new VoucherModel();
$invoker = new CommandInvoker();

// Function to regenerate session ID for security
function regenerateSession() {
    session_regenerate_id(true);
}

// Handling POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // GENERATE VOUCHER
    if (isset($_POST['generate_voucher'])) {
        $data = [
            'code' => $_POST['code'],
            'promotion_id' => $_POST['promotion_id'],
            'expiration_date' => $_POST['expiration_date'],
            'discount_percentage' => $_POST['discount_percentage'],
            'max_uses' => $_POST['max_uses']
        ];

        $command = new GenerateVoucherCommand($voucherModel, $data);
        try {
            $result = $invoker->setCommand($command)->executeCommand();
            if ($result === true) {
                regenerateSession(); // Regenerate session ID on critical actions
                header("Location: ../views/view_voucher.php");
                exit();
            } else {
                $_SESSION['error'] = $result;
                header("Location: ../views/generate_voucher.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../views/generate_voucher.php");
            exit();
        }
    }
if (isset($_POST['edit_voucher'])) {
    $data = [
        'code' => $_POST['code'],
        'promotion_id' => $_POST['promotion_id'],
        'expiration_date' => $_POST['expiration_date'],
        'discount_percentage' => $_POST['discount_percentage'],
        'max_uses' => $_POST['max_uses'],
        'times_used' => $_POST['times_used'] // Ensure this is included
    ];
    $id = $_POST['id'];

    // Update the voucher
    $result = $voucherModel->updateVoucher($id, $data);
    if ($result) {
        $_SESSION['success'] = 'Voucher updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update voucher.';
    }
    header("Location: ../views/view_voucher.php");
    exit();
}
   

    // DELETE VOUCHER
    if (isset($_POST['delete_voucher'])) {
        $id = $_POST['id'];

        try {
            $result = $voucherModel->deleteVoucher($id);
            if ($result === true) {
                regenerateSession(); // Regenerate session ID on critical actions
                $_SESSION['success'] = 'Voucher deleted successfully.';
                header("Location: ../views/view_voucher.php");
                exit();
            } else {
                $_SESSION['error'] = 'Failed to delete the voucher.';
                header("Location: ../views/view_voucher.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../views/view_voucher.php");
            exit();
        }
    }
}
?>
