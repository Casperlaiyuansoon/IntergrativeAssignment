<?php
session_start();
include_once '../config/Database.php';
include_once '../proxy/UserProxy.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);
$errors = [];
$admin = null;

// Check if the form was submitted and if admin ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // Retrieve admin data using the UserProxy
    $admin = $proxy->getAdminById($admin_id);

    if (!$admin) {
        $errors[] = "Admin not found.";
    }
} else {
    $errors[] = "No admin ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/viewAdmin.css">
</head>

<body>
    <div class="container">
        <h1>View Admin</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($admin)): ?>
            <div class="form-group">
                <label>Admin ID:</label>
                <p><?php echo htmlspecialchars($admin['admin_id'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Username:</label>
                <p><?php echo htmlspecialchars($admin['usernameAdmin'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <p><?php echo htmlspecialchars($admin['emailAdmin'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <p><?php echo htmlspecialchars($admin['phoneAdmin'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <p><?php echo htmlspecialchars($admin['role'], ENT_QUOTES); ?></p>
            </div>
            <div class="form-group">
                <label>Created At:</label>
                <p><?php echo htmlspecialchars($admin['createAt'], ENT_QUOTES); ?></p>
            </div>
        <?php else: ?>
            <p>Admin data not available. Please try again.</p>
        <?php endif; ?>
        <form action="user.php" method="POST">
            <button type="submit" name="back" class="backBtn">Back</button>
        </form>
    </div>
</body>

</html>
