<?php
include_once '../models/PromotionModel.php';
include_once '../models/DatabaseConnection.php';

// Initialize variables and error message
$title = $description = $discount_percentage = $start_date = $end_date = "";
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_promotion'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Get today's date
    $today = date('Y-m-d');

    // Validation logic
    if ($start_date < $today) {
        $error_message = "Start date cannot be in the past.";
    } elseif ($end_date < $today) {
        $error_message = "End date cannot be in the past.";
    } elseif ($end_date < $start_date) {
        $error_message = "End date cannot be earlier than the start date.";
    } else {
        // Instantiate the promotion model
        $promotionModel = new PromotionModel();

        // Prepare the data array
        $data = [
            'title' => $title,
            'description' => $description,
            'discount_percentage' => $discount_percentage,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        // Save the promotion using the addPromotion method
        if ($promotionModel->addPromotion($data)) {
            header("Location: view_promotion.php"); // Redirect to view promotions
            exit();
        } else {
            $error_message = "Error saving promotion. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion</title>
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
        input[type="text"], input[type="number"], input[type="date"], textarea {
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
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
    <script>
        // JavaScript to set today's date as the minimum date
        window.onload = function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("start_date").setAttribute("min", today);
            document.getElementById("end_date").setAttribute("min", today);
        };
    </script>
</head>
<body>
    <h1>Add a New Promotion</h1>
    
    <form method="POST" action="">
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

        <label for="discount_percentage">Discount Percentage:</label>
        <input type="number" id="discount_percentage" name="discount_percentage" value="<?php echo htmlspecialchars($discount_percentage); ?>" required step="0.01" min="0">

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>

        <input type="submit" name="add_promotion" value="Add Promotion">
    </form>
</body>
</html>
