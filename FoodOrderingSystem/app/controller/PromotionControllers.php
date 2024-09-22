<?php
session_start();
include_once '../models/PromotionModel.php';
include_once '../models/DatabaseConnection.php';
include_once '../commands/Command.php';
include_once '../commands/AddPromotionCommand.php';
include_once '../commands/EditPromotionCommand.php';
include_once '../commands/DeletePromotionCommand.php';
include_once '../commands/CommandInvoker.php';

// Initialize the database connection and model
$promotionModel = new PromotionModel();
$invoker = new CommandInvoker();

// Function to regenerate session ID for security
function regenerateSession() {
    session_regenerate_id(true);
}

// Handling POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['add_promotion'])) { // ADD
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'discount_percentage' => $_POST['discount_percentage'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date']
        ];

        $command = new AddPromotionCommand($promotionModel, $data);
        try {
            $result = $invoker->setCommand($command)->executeCommand();
            if ($result === true) {
                regenerateSession(); // Regenerate session ID on critical actions
                header("Location: ../views/view_promotion.php");
                exit();
            } else {
                $_SESSION['error'] = $result;
                header("Location: ../views/add_promotion.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../views/add_promotion.php");
            exit();
        }
    }

    if (isset($_POST['edit_promotion'])) { // EDIT
        $data = [
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'discount_percentage' => $_POST['discount_percentage'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date']
        ];

        $command = new EditPromotionCommand($promotionModel, $data);
        try {
            $result = $invoker->setCommand($command)->executeCommand();
            if ($result === true) {
                regenerateSession(); // Regenerate session ID on critical actions
                header("Location: ../views/view_promotion.php");
                exit();
            } else {
                $_SESSION['error'] = $result;
                header("Location: ../views/edit_promotion.php?id={$data['id']}");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../views/edit_promotion.php?id={$data['id']}");
            exit();
        }
    }

    if (isset($_POST['delete_promotion'])) { // DELETE
        $id = $_POST['id'];

        $command = new DeletePromotionCommand($promotionModel, $id);
        try {
            $invoker->setCommand($command)->executeCommand();
            regenerateSession(); // Regenerate session ID on critical actions
            header("Location: ../views/view_promotion.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
            error_log($e->getMessage()); // Log the error for debugging
            header("Location: ../views/view_promotion.php");
            exit();
        }
    }
    
    $customers = $this->getAllCustomers(); // You need to implement this method

foreach ($customers as $customer) {
    $notificationMessage = "New promotion: {$promotion['title']} with discount of {$promotion['discount_percentage']}%. Check it out!";
    $sendNotificationCommand = new SendNotificationCommand($notificationModel, $customer['id'], $promotion['id'], $notificationMessage);
    $sendNotificationCommand->execute();
}
}
?>
