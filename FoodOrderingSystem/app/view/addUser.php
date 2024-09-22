<?php
session_start();
include_once '../config/Database.php';
include_once '../proxy/UserProxy.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$proxy = new UserProxy($role);

$errors = [];
$success_message = "";

// Handle form submission for adding new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $status = $_POST['status'];

    // Basic validation
    if (empty($username) || empty($email) || empty($phone_number) || empty($password) || empty($confirm_password) || empty($status)) {
        $errors[] = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } else {
        // Password rule checks
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number.";
        }
        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = "Password must contain at least one special character.";
        }
    }

    // If no errors, proceed with adding the user
    if (empty($errors)) {
        try {
            if ($proxy->addUser($username, $email, $phone_number, $password, $status)) {
                $success_message = "User added successfully!";
            } else {
                $errors[] = "Error adding user.";
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage(); // Catch permission denied or other exceptions
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../../public/css/addUser.css">
</head>

<body>
    <div class="container">
        <h1>Add New User</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($success_message, ENT_QUOTES); ?></p>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="banned">Banned</option>
                </select>
            </div>
            <button type="submit" name="add_user">Add User</button>
        </form>
        <form action="user.php" method="post">
            <button type="submit" name="back" class="backBtn">Back</button>
        </form>
    </div>
</body>

</html>
