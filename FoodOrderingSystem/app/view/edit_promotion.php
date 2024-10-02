<?php
session_start();
include_once '../models/PromotionModel.php';
include_once '../models/DatabaseConnection.php';


$promotionModel = new PromotionModel();

$promotion = null; // Initialize $promotion to prevent the undefined variable error

if (isset($_GET['id'])) {
    $promotion = $promotionModel->getPromotionById($_GET['id']);

    // Check if the promotion exists
    if (!$promotion) {
        $_SESSION['error'] = "Promotion not found!";
    exit();}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
   <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f4f4f4;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"], input[type="number"], input[type="date"], textarea {
        width: calc(100% - 22px);
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .error {
        color: red;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }

    p {
        text-align: center;
        color: red;
    }
</style>
</head>
<body>
    <h1>Edit Promotion</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); // Clear the error after displaying ?>
    <?php endif; ?>

    <?php if ($promotion): ?>
        <form method="POST" action="../controller/PromotionControllers.php">
            <input type="hidden" name="id" value="<?php echo $promotion['id']; ?>">
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $promotion['title']; ?>" required><br>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $promotion['description']; ?></textarea><br>

            <label for="discount_percentage">Discount Percentage:</label>
            <input type="number" id="discount_percentage" name="discount_percentage" value="<?php echo $promotion['discount_percentage']; ?>" required><br>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $promotion['start_date']; ?>" required><br>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $promotion['end_date']; ?>" required><br>

            <input type="submit" name="edit_promotion" value="Update Promotion">
        </form>
    <?php else: ?>
        <p>Promotion not found!</p>
    <?php endif; ?>
</body>
</html>
