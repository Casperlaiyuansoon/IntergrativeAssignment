<?php
session_start();

// Include database and User model
include_once '../config/Database.php';
include_once '../models/adminLoginModal.php';

// Connect to database
$database = new Database();
$db = $database->getConnection();

// Initialize the User model
$admin = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameAdmin = trim($_POST['usernameAdmin']);
    $passwordAdmin = trim($_POST['passwordAdmin']);

    if (!empty($usernameAdmin) && !empty($passwordAdmin)) {
        // Attempt to find the user by username
        if ($admin->findByAdminname($usernameAdmin)) {
            // Verify the password
            if (password_verify($passwordAdmin, $admin->passwordAdmin)) {
                // Successful login, regenerate session ID
                session_regenerate_id(true);
                // Successful login, set session variables
                $_SESSION['admin_id'] = $admin->admin_id;
                $_SESSION['usernameAdmin'] = $admin->usernameAdmin;
                $_SESSION['role'] = $admin->role;
                $_SESSION['login_time'] = time();

                // Redirect to admin homepage
                header("Location: admin/adminmenu.php");
                exit();
            } else {
                $error_message = "Invalid username or password!";
            }
        } else {
            $error_message = "Invalid username or password!";
        }
    } else {
        $error_message = "Please enter both username and password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../public/css/login.css">
    <link rel="shortcut icon" href="image/short_icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .error_message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>

    <div class="hero">

        <div class="login_form">

            <h1>Admin Login</h1>

            <?php if (isset($error_message)): ?>
                <div class="error_message"><?php echo htmlspecialchars($error_message, ENT_QUOTES); ?></div>
            <?php endif; ?>

            <form class="input_box" method="POST" action="">
                <input type="text" name="usernameAdmin" class="field" placeholder="User Name"
                    value="<?php echo htmlspecialchars($_POST['usernameAdmin'] ?? '', ENT_QUOTES); ?>">
                <input type="password" name="passwordAdmin" class="field" autocomplete="off" placeholder="Password">
                <input type="checkbox" class="check_box">
                <p>Remember Password</p>
                <button type="submit" class="submit_btn">Login</button>

                <div class="social_icon">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-google"></i>
                </div>
                
                <div class="tag" style="text-align:center; font-weight:bold; background-color:grey;">
                    <span>Not Admin?</span>
                    <a href="Login.php">User</a>
                </div>
            </form>

        </div>

    </div>

</body>

</html>