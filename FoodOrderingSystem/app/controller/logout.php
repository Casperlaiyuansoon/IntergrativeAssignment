<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Check if session variables are cleared
if (empty($_SESSION)) {
    $session_status = "Session cleared successfully.";
} else {
    $session_status = "Session variables still exist.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 20%;
            background-color: #f0f0f0;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="message">
    Logging out... You will be redirected shortly.<br>
    <?php echo $session_status; // Display session status ?>
</div>

<?php
header("Refresh: 2; URL=../view/homepage.php"); // Redirect to login page after 2 seconds
?>

</body>
</html>
