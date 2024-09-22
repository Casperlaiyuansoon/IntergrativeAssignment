<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'models/PromotionModel.php';
include_once 'commands/AddPromotionCommand.php';
include_once 'commands/EditPromotionCommand.php';
include_once 'commands/DeletePromotionCommand.php';
include_once 'commands/CommandInvoker.php';

$promotionModel = new PromotionModel();
$invoker = new CommandInvoker();
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Helper function to parse JSON data
function getInputData() {
    if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
        return json_decode(file_get_contents('php://input'), true);
    }
    return $_POST;
}

// Helper function for date validation
function validateDate($date, $isEndDate = false, $startDate = null) {
    $today = new DateTime();
    $inputDate = DateTime::createFromFormat('Y-m-d', $date);

    if (!$inputDate || $inputDate->format('Y-m-d') !== $date) {
        return ['success' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD.'];
    }

    if ($inputDate < $today) {
        return ['success' => false, 'message' => 'Start date cannot be in the past.'];
    }

    if ($isEndDate && $startDate) {
        $startDateTime = DateTime::createFromFormat('Y-m-d', $startDate);
        if ($inputDate < $startDateTime) {
            return ['success' => false, 'message' => 'End date must be after start date.'];
        }
    }

    return ['success' => true];
}

// Handle the request
switch ($requestMethod) {
    case 'POST':
        $data = getInputData();
        
        if (!isset($data['title'], $data['description'], $data['start_date'], $data['end_date'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit;
        }

        $startDateValidation = validateDate($data['start_date']);
        if (!$startDateValidation['success']) {
            http_response_code(400);
            echo json_encode($startDateValidation);
            exit;
        }

        $endDateValidation = validateDate($data['end_date'], true, $data['start_date']);
        if (!$endDateValidation['success']) {
            http_response_code(400);
            echo json_encode($endDateValidation);
            exit;
        }

        $command = new AddPromotionCommand($promotionModel, $data);
        try {
            $invoker->setCommand($command)->executeCommand();
            http_response_code(201);
            echo json_encode(['success' => true, 'message' => 'Promotion created successfully.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
        }
        break;

    case 'GET':
        try {
            $promotions = $promotionModel->getAllPromotions();
            http_response_code(200);
            echo json_encode(['success' => true, 'data' => $promotions]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
        }
        break;

    case 'PUT':
        $data = getInputData();
        
        if (!isset($data['id'], $data['title'], $data['description'], $data['start_date'], $data['end_date'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit;
        }

        $startDateValidation = validateDate($data['start_date']);
        if (!$startDateValidation['success']) {
            http_response_code(400);
            echo json_encode($startDateValidation);
            exit;
        }

        $endDateValidation = validateDate($data['end_date'], true, $data['start_date']);
        if (!$endDateValidation['success']) {
            http_response_code(400);
            echo json_encode($endDateValidation);
            exit;
        }

        $command = new EditPromotionCommand($promotionModel, $data);
        try {
            $invoker->setCommand($command)->executeCommand();
            http_response_code(200); // Or 204 if you want no content
            echo json_encode(['success' => true, 'message' => 'Promotion updated successfully.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        $data = getInputData();
        
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit;
        }

        $command = new DeletePromotionCommand($promotionModel, $data['id']);
        try {
            $invoker->setCommand($command)->executeCommand();
            http_response_code(204); // No content for successful delete
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>
