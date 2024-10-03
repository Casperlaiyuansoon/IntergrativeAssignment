<?php
session_start();
include_once '../models/VoucherModel.php';
include_once '../models/PromotionModel.php'; // Include the PromotionModel
include_once '../models/DatabaseConnection.php';
include_once '../commands/Command.php';
include_once '../commands/GenerateVoucherCommand.php';
include_once '../commands/CommandInvoker.php';

// Database connection
$conn = DatabaseConnection::getInstance();
$voucherModel = new VoucherModel();
$promotionModel = new PromotionModel(); // Create an instance of PromotionModel
$invoker = new CommandInvoker();

// Function to regenerate session ID for security
function regenerateSession() {
    session_regenerate_id(true);
}

// Handling POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // GENERATE VOUCHER
    if (isset($_POST['generate_voucher'])) {
        $code = $_POST['code'];
        $data = [
            'code' => $_POST['code'],
            'promotion_id' => $_POST['promotion_id'],
            'expiration_date' => $_POST['expiration_date'],
            'discount_percentage' => $_POST['discount_percentage'],
            'max_uses' => $_POST['max_uses']
        ];

          // Check if the voucher code already exists
          $existingVoucher = $voucherModel->getVoucherByCode($code);
          if ($existingVoucher) {
              // Set error message and redirect if voucher code exists
              $_SESSION['error'] = 'Voucher code already exists. Please choose a different code.';
              header("Location: ../view/generate_voucher.php");
              exit();
          }
        // Check if the promotion_id exists
        $promotion = $promotionModel->getPromotionById($data['promotion_id']);
        
        if (!$promotion) {
            // Set error message and redirect if the promotion_id is invalid
            $_SESSION['error'] = 'Invalid promotion ID.';
            header("Location: ../view/generate_voucher.php");
            exit();
        }

        $command = new GenerateVoucherCommand($voucherModel, $data);
        try {
            $result = $invoker->setCommand($command)->executeCommand();
            if ($result === true) {
                regenerateSession(); // Regenerate session ID on critical actions
                $_SESSION['success'] = 'Voucher generated successfully.';
                header("Location: ../view/view_voucher.php");
                exit();
            } else {
                $_SESSION['error'] = $result;
                header("Location: ../view/generate_voucher.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../view/generate_voucher.php");
            exit();
        }
    }

    // EDIT VOUCHER
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

        // Check if the promotion_id exists
        $promotion = $promotionModel->getPromotionById($data['promotion_id']);
        if (!$promotion) {
            // Set error message and redirect if the promotion_id is invalid
            $_SESSION['error'] = 'Invalid promotion ID.';
            header("Location: ../view/edit_voucher.php?id=$id");
            exit();
        }

           // Check for duplicate voucher code
    if ($voucherModel->isDuplicateCode($data['code'], $id)) {
        // Set error message and redirect if the voucher code is already taken
        $_SESSION['error'] = 'Voucher code already exists. Please choose a different code.';
        header("Location: ../view/edit_voucher.php?id=$id");
        exit();
    }

        // Try updating the voucher
    try {
        $result = $voucherModel->updateVoucher($id, $data);
        if ($result) {
            $_SESSION['success'] = 'Voucher updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update voucher.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'An error occurred. Please try again later.';
        error_log($e->getMessage()); // Log the error for debugging
    }

    header("Location: ../view/view_voucher.php");
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
                header("Location: ../view/view_voucher.php");
                exit();
            } else {
                $_SESSION['error'] = 'Failed to delete the voucher.';
                header("Location: ../view/view_voucher.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../view/view_voucher.php");
            exit();
        }
    }
}
?>
