<?php
session_start();

// Include database connection
include_once '../config/userdatabase.php';
include_once '../models/userProfileModal.php';

// Create a new Database instance and get the connection
$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success_message = "";
$userModel = new User($conn); // Create an instance of the User model
$user_id = $_SESSION['user_id'];
$user = $userModel->find($user_id); // Fetch user data

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $phone_number = trim($_POST['phone_number']);

    if (empty($phone_number)) {
        $errors[] = "Phone number is required.";
    }

    if (empty($errors)) {
        if ($userModel->updateProfile($user_id, $phone_number)) {
            $success_message = "Profile updated successfully!";
        } else {
            $errors[] = "Error updating profile.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirmpassword'];

    if (!empty($current_password) || !empty($new_password) || !empty($confirm_new_password)) {
        if (!password_verify($current_password, $user['password'])) {
            $errors[] = "Original password is incorrect.";
        } elseif ($new_password !== $confirm_new_password) {
            $errors[] = "New password and confirmation do not match.";
        } elseif (empty($new_password)) {
            $errors[] = "New password cannot be empty.";
        }

        if (empty($errors)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            if ($userModel->updatePassword($user_id, $hashed_password)) {
                $success_message = "Password updated successfully!";
            } else {
                $errors[] = "Error updating password.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../../public/css/userProfile.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="profile-page">
        <div class="profile-container">
            <h1>User Profile</h1>

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

            <div class="profile-form-container">
                <!-- User Information Section -->
                <div class="user-info">
                    <form method="POST" action="">
                        <h3>User Information</h3>
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" id="user_id" name="user_id"
                                value="<?php echo htmlspecialchars($user['user_id'] ?? '', ENT_QUOTES); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username"
                                value="<?php echo htmlspecialchars($user['username'] ?? '', ENT_QUOTES); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number"
                                value="<?php echo htmlspecialchars($user['phone_number'] ?? '', ENT_QUOTES); ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="createAt">Account Created On</label>
                            <input type="text" id="createAt" name="createAt"
                                value="<?php echo htmlspecialchars($user['createAt'], ENT_QUOTES); ?>" disabled>
                        </div>

                        <div class="buttons">
                            <button type="submit" name="update_profile">Update Profile</button>
                            <a href="homepage.php" class="back-home-btn">Back to Home</a>
                        </div>
                    </form>
                </div>

                <!-- Password Section -->
                <div class="password-section">
                    <form method="POST" action="">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                placeholder="Current Password">
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirm New Password</label>
                            <input type="password" id="confirmpassword" name="confirmpassword"
                                placeholder="Confirm New Password">
                        </div>

                        <div class="buttons">
                            <button type="submit" name="change_password">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>