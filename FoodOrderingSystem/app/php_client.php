<?php
// Display all PHP errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Base URL for API
define('API_URL', "http://127.0.0.1:5000/");

// Function to fetch data from API
function fetchData($endpoint) {
    $url = API_URL . $endpoint;
    $context = stream_context_create([
        'http' => [
            'ignore_errors' => true
        ]
    ]);
    $response = file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        $error = error_get_last();
        return [
            'success' => false, 
            'message' => 'Failed to fetch data: ' . $error['message'], 
            'http_code' => $http_response_header[0] ?? 'Unknown HTTP code'
        ];
    }
    
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'message' => 'Failed to parse JSON response: ' . json_last_error_msg(),
            'http_code' => $http_response_header[0] ?? 'Unknown HTTP code'
        ];
    }
    
    return $data;
}

// Function to send data to the API
function sendData($endpoint, $data, $method = 'POST') {
    $url = API_URL . $endpoint;
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => $method,
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        return ['success' => false, 'message' => 'Failed to send data.', 'http_code' => 500];
    }

    $httpCode = http_response_code(); // Get the actual HTTP response code
    return [
        'data' => json_decode($response, true),
        'http_code' => $httpCode,
        'success' => strpos($httpCode, '200') === 0
    ];
}

// Fetch promotions and notifications
$promotions = fetchData('promotions');
$notifications = fetchData('notifications');

// Process form submission
$formMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // Log the POST data for debugging
    error_log(print_r($_POST, true)); 

    switch ($action) {
        case 'create':
            if (empty($_POST['user_id']) || empty($_POST['promotion_id']) || empty($_POST['message'])) {
                $formMessage = "All fields are required to create a notification.";
            } else {
                $newNotification = [
                    'user_id' => htmlspecialchars(trim($_POST['user_id'])),
                    'promotion_id' => htmlspecialchars(trim($_POST['promotion_id'])),
                    'message' => htmlspecialchars(trim($_POST['message'])),
                ];
                $response = sendData('notifications', $newNotification);
                $formMessage = $response['success'] ? "Notification created successfully." : "Failed to create notification: " . htmlspecialchars($response['message']) . " (HTTP Code: " . $response['http_code'] . ")";
            }
            break;

        case 'update':
            if (empty($_POST['id']) || empty($_POST['user_id']) || empty($_POST['promotion_id']) || empty($_POST['message'])) {
                $formMessage = "All fields are required to update a notification.";
            } else {
                $updateNotification = [
                    'id' => htmlspecialchars(trim($_POST['id'])),
                    'user_id' => htmlspecialchars(trim($_POST['user_id'])),
                    'promotion_id' => htmlspecialchars(trim($_POST['promotion_id'])),
                    'message' => htmlspecialchars(trim($_POST['message'])),
                    'status' => htmlspecialchars(trim($_POST['status'])),
                ];
                $response = sendData("notifications/" . $_POST['id'], $updateNotification, 'PUT');
                $formMessage = $response['success'] ? "Notification updated successfully." : "Failed to update notification: " . htmlspecialchars($response['message']) . " (HTTP Code: " . $response['http_code'] . ")";
            }
            break;

        case 'delete':
            if (empty($_POST['id'])) {
                $formMessage = "Notification ID is required to delete a notification.";
            } else {
                $response = sendData("notifications/" . $_POST['id'], [], 'DELETE');
                $formMessage = $response['success'] ? "Notification deleted successfully." : "Failed to delete notification: " . htmlspecialchars($response['message']) . " (HTTP Code: " . $response['http_code'] . ")";
            }
            break;

        default:
            $formMessage = "Invalid action.";
            break;
    }
}
?>

<!-- HTML Display Section -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification Management</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #333; }
        form { margin-top: 20px; }
        input, select { margin: 5px; padding: 8px; }
        .message { font-weight: bold; color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Available Promotions</h2>
    <ul>
        <?php if ($promotions['success']): ?>
            <?php foreach ($promotions['data'] as $promotion): ?>
                <li><?php echo htmlspecialchars($promotion['title']) . ": " . htmlspecialchars($promotion['description']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="error"><?php echo htmlspecialchars($promotions['message']); ?></li>
        <?php endif; ?>
    </ul>

    <h2>Current Notifications</h2>
    <ul>
        <?php if ($notifications['success']): ?>
            <?php foreach ($notifications['data'] as $notification): ?>
                <li>Notification #<?php echo htmlspecialchars($notification['id']); ?>: <?php echo htmlspecialchars($notification['message']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="error"><?php echo htmlspecialchars($notifications['message']); ?></li>
        <?php endif; ?>
    </ul>

    <?php if ($formMessage): ?>
        <p class="<?php echo strpos($formMessage, 'Failed') !== false ? 'error' : 'message'; ?>">
            <?php echo htmlspecialchars($formMessage); ?>
        </p>
    <?php endif; ?>

    <form method="post" onsubmit="return confirmDelete();">
        <h3>Choose an action:</h3>
        <select name="action" onchange="toggleFields()" required>
            <option value="">Select Action</option>
            <!-- <option value="create">Create</option> -->
            <!-- <option value="update">Update</option> -->
            <option value="delete">Delete</option>
        </select>
        <br><br>

        <div id="createFields" style="display: none;">
            <h4>Create Notification</h4>
            Customer ID: <input type="text" name="user_id"><br>
            Promotion ID: <input type="text" name="promotion_id"><br>
            Message: <input type="text" name="message"><br>
        </div>

        <div id="updateFields" style="display: none;">
            <h4>Update Notification</h4>
            Notification ID: <input type="text" name="id"><br>
            Customer ID: <input type="text" name="user_id"><br>
            Promotion ID: <input type="text" name="promotion_id"><br>
            Message: <input type="text" name="message"><br>
            Status: <input type="text" name="status"><br>
        </div>

        <div id="deleteFields" style="display: none;">
            <h4>Delete Notification</h4>
            Notification ID: <input type="text" name="id"><br>
        </div>

        <br>
        <input type="submit" value="Submit">
    </form>

    <script>
        function toggleFields() {
            const actionSelect = document.querySelector('select[name="action"]');
            document.getElementById('createFields').style.display = 'none';
            document.getElementById('updateFields').style.display = 'none';
            document.getElementById('deleteFields').style.display = 'none';

            if (actionSelect.value === 'create') {
                document.getElementById('createFields').style.display = 'block';
            } else if (actionSelect.value === 'update') {
                document.getElementById('updateFields').style.display = 'block';
            } else if (actionSelect.value === 'delete') {
                document.getElementById('deleteFields').style.display = 'block';
            }
        }

        function confirmDelete() {
            const action = document.querySelector('select[name="action"]').value;
            if (action === 'delete') {
                const confirmation = confirm("Are you sure you want to delete this notification?");
                if (!confirmation) {
                    return false; // Prevent form submission
                }
            }
            return true; // Allow form submission
        }
    </script>
</body>
</html>
