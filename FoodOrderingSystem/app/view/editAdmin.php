<?php
session_start();
include_once '../config/Database.php';
include_once '../proxy/UserProxy.php';
include_once '../models/UserAdminManager.php';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Initialize UserProxy with the user's role
$proxy = new UserProxy($role);

$manager = new UserAdminManager();
$errors = [];
$success_message = "";
$admin = null;

// Check if the form was submitted and if admin ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // Retrieve admin data using the admin_id
    $admin = $manager->getAdminById($admin_id);

    if (!$admin) {
        $errors[] = "Admin not found.";
    }
} else {
    $errors[] = "No admin ID provided.";
}

// Handle form submission for editing admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_admin'])) {
    $admin_id = $_POST['admin_id'];
    $username = trim($_POST['username']);
    $phone_number = trim($_POST['phone_number']);
    $role = $_POST['role'];

    // Basic validation
    if (empty($username) || empty($phone_number) || empty($role)) {
        $errors[] = "All fields are required.";
    }

    // If no errors, proceed with updating the admin
    if (empty($errors)) {
        // Use UserProxy to update the admin
        try {
            if ($proxy->updateAdmin($admin_id, $username, $admin['emailAdmin'], $phone_number, $role)) {
                $success_message = "Admin updated successfully!";
                // Reload the admin data after updating
                $admin = $manager->getAdminById($admin_id);
            } else {
                $errors[] = "Error updating admin.";
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
    <title>Edit Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../../public/css/editAdmin.css">
</head>

<body>
    <div class="container">
        <h1>Edit Admin</h1>
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
        <?php if (!empty($admin)): ?>
            <form method="POST" action="">
                <input type="hidden" name="admin_id"
                    value="<?php echo htmlspecialchars($admin['admin_id'], ENT_QUOTES); ?>">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                        value="<?php echo htmlspecialchars($admin['usernameAdmin'], ENT_QUOTES); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email"
                        value="<?php echo htmlspecialchars($admin['emailAdmin'], ENT_QUOTES); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number"
                        value="<?php echo htmlspecialchars($admin['phoneAdmin'], ENT_QUOTES); ?>" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="admin" <?php echo $admin['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="moderator" <?php echo $admin['role'] == 'moderator' ? 'selected' : ''; ?>>Moderator</option>
                        <option value="staff" <?php echo $admin['role'] == 'staff' ? 'selected' : ''; ?>>Staff</option>
                    </select>
                </div>
                <button type="submit" name="edit_admin">Update Admin</button>
            </form>
        <?php else: ?>
            <p>Admin data not available. Please try again.</p>
        <?php endif; ?>
        <form action="user.php">
            <button type="submit" name="back" class="backBtn">Back</button>
        </form>
    </div>
</body>

</html>
