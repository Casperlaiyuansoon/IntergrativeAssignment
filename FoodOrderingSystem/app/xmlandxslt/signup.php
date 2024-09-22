<?php
include_once '../config/Database.php';
include_once '../models/signupModal.php';

$errors = [];
$success_message = '';

// Create a Database instance and connect to the database
$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    $phone_number = trim($_POST['phone_number']);

    // Basic validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($phone_number)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^(\+?60|0)[0-9]{1,2}-[0-9]{7,8}$/', $phone_number)) {
        $errors[] = "Please enter a valid phone number in Malaysia format (e.g., 012-3456789 or +6012-3456789).";
    }
    if (empty($password) || empty($confirm_password)) {
        $errors[] = "Both password fields are required.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } else {
        // Check for password strength
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
        if (!preg_match('/[\W_]/', $password)) { // Matches any non-word character
            $errors[] = "Password must contain at least one special character (e.g., @, #, $, etc.).";
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Instantiate User model
        $user = new User($db);

        // Set the user properties
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        $user->phone_number = $phone_number;

        // Try to create the user
        if ($user->create()) {
            $success_message = "Registration successful!";
        } else {
            $errors[] = "Error occurred during registration.";
        }
    }
}

// Load XML and XSLT
$xml = new DOMDocument;
$xml->load('signup_form.xml');

$xsl = new DOMDocument;
$xsl->load('signup_form.xslt');

// Initialize the XSLTProcessor
$proc = new XSLTProcessor();

// Import the XSLT stylesheet into the processor
$signup_form_html = '';  // Declare the variable to hold transformed HTML
if ($proc->importStylesheet($xsl)) {
    // Transform the XML into HTML
    $signup_form_html = $proc->transformToXML($xml);
} else {
    echo "Failed to import XSLT stylesheet.";
}
?>

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../public/css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="image/short_icon.png">
</head>

<body>

    <!-- Error and Success Messages -->
    <div class="error-section">
        <?php if (!empty($errors)): ?>
            <div class="error_block">
                <h3>There were some issues with your submission:</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success_block">
                <p><?php echo htmlspecialchars($success_message, ENT_QUOTES); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Transformed Signup Form -->
    <?php echo $signup_form_html; ?>

</body>

</html>
