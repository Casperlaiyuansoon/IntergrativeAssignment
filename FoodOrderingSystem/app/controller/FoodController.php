<?php

require_once '../../models/Food.php';
require_once '../../config/Database.php';
require_once '../../observers/EmailNotificationObserver.php';
require_once '../../observers/LoggingObserver.php';

// Create a new database connection
$database = new Database();
$db = $database->getConnection();

// Instantiate Food model
$food = new Food($db);

// Instantiate observers
$emailObserver = new EmailNotificationObserver();
$logObserver = new LoggingObserver();

// Attach observers to food
$food->attach($emailObserver);
$food->attach($logObserver);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the uploads directory exists
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory with permissions
    }

    // Handle file upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imagePath = $uploadDir . basename($imageName);

        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            echo "Failed to upload file.";
            $imagePath = null;
        }
    }

    // Create or update food item
    $food->name = $_POST['name'];
    $food->price = $_POST['price'];
    $food->image = $imagePath; // Store the file path

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $food->id = $_POST['id'];
        if ($food->update()) {
            echo "";
        } else {
            echo "Failed to update food item.";
        }
    } else {
        if ($food->create()) {
            echo "";
        } else {
            echo "Failed to create food item.";
        }
    }
} elseif (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $food->id = $_GET['id'];
        if ($food->delete()) {
            echo "";
        } else {
            echo "Failed to delete food item.";
        }
    } elseif ($_GET['action'] == 'edit') {
        $food->id = $_GET['id'];
        $stmt = $food->read()->fetch(PDO::FETCH_ASSOC);
        if ($stmt) {
            $foodId = $stmt['id'];
            $foodName = $stmt['name'];
            $foodPrice = $stmt['price'];
            $foodImage = $stmt['image'];
        }
    }
    
}





