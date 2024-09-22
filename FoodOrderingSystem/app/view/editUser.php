<?php
session_start();
include_once '../config/userdatabase.php';
include_once '../proxy/UserProxy.php';
include_once '../model/UserAdminManager.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);

$manager = new UserAdminManager();
$errors = [];
$success_message = "";
$admin = null;

// Check if the form was submitted and if user ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Retrieve user data using the user_id
    $user = $manager->getUserById($user_id);

    if (!$user) {
        $errors[] = "User not found.";
    }
} else {
    $errors[] = "No user ID provided.";
}

// Handle form submission for editing user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $phone_number = trim($_POST['phone_number']);
    $status = $_POST['status'];

    // Basic validation
    if (empty($username) || empty($phone_number) || empty($status)) {
        $errors[] = "All fields are required.";
    }

    // If no errors, proceed with updating the user
    if (empty($errors)) {
        // Use UserProxy to update the admin
        try {
            if ($manager->updateUser($user_id, $username, $user['email'], $phone_number, $status)) {
                $success_message = "User updated successfully!";
                // Reload the user data after updating
                $user = $manager->getUserById($user_id);
            } else {
                $errors[] = "Error updating user.";
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage(); // Catch any exceptions
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../../public/css/editUser.css">
</head>

<body>
    <div class="container">
        <h1>Edit User</h1>
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
        <?php if (!empty($user)): ?>
            <form method="POST" action="">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id'], ENT_QUOTES); ?>">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                        value="<?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number"
                        value="<?php echo htmlspecialchars($user['phone_number'], ENT_QUOTES); ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive
                        </option>
                        <option value="banned" <?php echo $user['status'] == 'banned' ? 'selected' : ''; ?>>Banned</option>
                    </select>
                </div>
                <button type="submit" name="edit_user">Update User</button>
            </form>
        <?php else: ?>
            <p>User data not available. Please try again.</p>
        <?php endif; ?>
        <form action="user.php">
            <button type="submit" name="back" class="backBtn">Back</button>
        </form>
    </div>
</body>

</html>