<?php
session_start(); // Start the session

include_once '../config/Database.php';
include_once '../models/UserAdminManager.php';

// Define the checkSessionTimeout function
function checkSessionTimeout()
{
    $timeout_duration = 1800; // Set the session timeout duration (30 minutes)

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: adminLogin.php?session_expired=true");
        exit();
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time
}

// Check if user is authorized
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['Admin', 'Moderator', 'Staff'])) {
    header("Location: adminLogin.php"); // Redirect to login if not authorized
    exit();
}

// Check if the session has timed out
checkSessionTimeout();

$manager = new UserAdminManager();

// Initialize variables
$result_user = $manager->getAllUsers();
$result_admin = $manager->getAllAdmins();

// Handle search functionality for users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['search_user'])) {
        $result_user = $manager->searchUsers($_POST['search_user']);
    }
    if (!empty($_POST['search_admin'])) {
        $result_admin = $manager->searchAdmins($_POST['search_admin']);
    }
}

// Fetch count of users and admins
function fetchCountsCurl()
{
    $url = 'http://localhost:3000/api/count';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false) {
        return ['error' => 'Failed to connect to the server: ' . curl_error($ch)];
    }

    if ($httpCode !== 200) {
        return ['error' => 'Server returned an error: HTTP ' . $httpCode];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Failed to parse server response: ' . json_last_error_msg()];
    }

    return $data;
}

$counts = fetchCountsCurl();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/adminmenu.css">
    <link rel="stylesheet" href="../../public/css/user.css">
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><img src="../../public/image/logo.png"></span>
                        <span class="title">Food Ordering Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="admin/admindashboard.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="user.php">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">User</span>
                    </a>
                </li>

                <li>
                    <a href="admin/adminmenu.php">
                        <span class="icon"><ion-icon name="fast-food-outline"></ion-icon></span>
                        <span class="title">Menu</span>
                    </a>
                </li>

                <li>
                    <a href="admin/adminorder.php">
                        <span class="icon"><ion-icon name="bag-remove-outline"></ion-icon></span>
                        <span class="title">Order</span>
                    </a>
                </li>

                <li>
                    <a href="view_notification.php">
                        <span class="icon"><ion-icon name="notifications-outline"></ion-icon></span>
                        <span class="title">Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="pricetag-outline"></ion-icon></span>
                        <span class="title">Promotion</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="ticket-outline"></ion-icon></span>
                        <span class="title">Voucher</span>
                    </a>
                </li>
                <li>
                    <a href="../controller/adminLogout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="user"><img src="../../public/image/review_1.png" alt=""></div>
            </div>

            <!-- User Management Section -->
            <div class="container">
                <h1>User Management</h1>
                <form method="POST" action="addUser.php">
                    <button type="submit" name="new_user" class="button">New User</button>
                </form>
                <form method="POST" action="">
                    <label>
                        <input type="text" name="search_user" placeholder="Search User">
                        <input type="submit" value="Search" class="button">
                    </label>
                </form>

                <!-- Insert the user count display here -->
                <?php if (isset($counts['error'])): ?>
                    <p>Error fetching counts: <?php echo htmlspecialchars($counts['error']); ?></p>
                <?php else: ?>
                    <p>Total Users:
                        <?php echo isset($counts['user_count']) ? htmlspecialchars($counts['user_count']) : 'N/A'; ?>
                    </p>
                <?php endif; ?>

                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($result_user) > 0): ?>
                            <?php foreach ($result_user as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['createAt']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 15px; align-items: center;">
                                            <form method="POST" action="viewUser.php">
                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                <button type="submit" name="edit" class="button">View</button>
                                            </form>
                                            <form method="POST" action="editUser.php">
                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                <button type="submit" name="edit" class="button">Edit</button>
                                            </form>
                                            <button class="button deleteButton"
                                                onclick="deleteUser(<?php echo $row['user_id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Admin Management Section -->
            <div class="container">
                <h1>Admin Management</h1>
                <form method="POST" action="addAdmin.php">
                    <button type="submit" name="new_admin" class="button">New Admin</button>
                </form>
                <form method="POST" action="">
                    <label>
                        <input type="text" name="search_admin" placeholder="Search Admins">
                        <input type="submit" value="Search" class="button">
                    </label>
                </form>

                <!-- Insert the admin count display here -->
                <?php if (isset($counts['error'])): ?>
                    <p>Error fetching counts: <?php echo htmlspecialchars($counts['error']); ?></p>
                <?php else: ?>
                    <p>Total Admins:
                        <?php echo isset($counts['admin_count']) ? htmlspecialchars($counts['admin_count']) : 'N/A'; ?>
                    </p>
                <?php endif; ?>

                <table>
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created At</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($result_admin) > 0): ?>
                            <?php foreach ($result_admin as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['admin_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['usernameAdmin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['emailAdmin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phoneAdmin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['createAt']); ?></td>
                                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <form method="POST" action="viewAdmin.php" style="display: inline;">
                                                <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                                <button type="submit" name="edit" class="button">View</button>
                                            </form>
                                            <form method="POST" action="editAdmin.php" style="display: inline;">
                                                <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                                <button type="submit" name="edit" class="button">Edit</button>
                                            </form>
                                            <button class="button deleteButton"
                                                onclick="deleteAdmin(<?php echo $row['admin_id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No admins found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../public/js/adminmenu.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_user.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        location.reload(); // Reload the page to update the user list
                    } else {
                        alert("Error deleting user.");
                    }
                };
                xhr.send("id=" + userId);
            }
        }

        function deleteAdmin(adminId) {
            if (confirm("Are you sure you want to delete this admin?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_admin.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        location.reload(); // Reload the page to update the admin list
                    } else {
                        alert("Error deleting admin.");
                    }
                };
                xhr.send("id=" + adminId);
            }
        }
    </script>
</body>

</html>