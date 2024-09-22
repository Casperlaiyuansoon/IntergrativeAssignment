<?php
session_start();
include_once '../config/Database.php';
include_once '../proxy/UserProxy.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);
$errors = [];
$user = null;

// Check if the form was submitted and if user ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Retrieve user data using the UserProxy
    $user = $proxy->getUserById($user_id);

    if (!$user) {
        $errors[] = "User not found.";
    }
} else {
    $errors[] = "No user ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View User</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../../public/css/viewUser.css">
</head>

<body>
    <div class="container">
        <h1>View User</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($user)): ?>
            <div class="form-group">
                <label>User ID:</label>
                <p><?php echo htmlspecialchars($user['user_id'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Username:</label>
                <p><?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <p><?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <p><?php echo htmlspecialchars($user['phone_number'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <p><?php echo htmlspecialchars($user['status'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Created At:</label>
                <p><?php echo htmlspecialchars($user['createAt'], ENT_QUOTES); ?></p>
            </div>
        <?php else: ?>
            <p>User data not available. Please try again.</p>
        <?php endif; ?>
        <form action="user.php" method="POST">
            <button type="submit" name="back" class="backBtn">Back</button>
        </form>
    </div>
</body>

</html>