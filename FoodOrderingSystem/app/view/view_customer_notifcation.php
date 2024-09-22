<?php
session_start();
include_once '../models/NotificationModel.php';
include_once '../models/DatabaseConnection.php';

// Simulate a customer session (for testing purposes)
$_SESSION['customer_id'] = 1; // Simulated customer ID

// Create a connection instance
$conn = DatabaseConnection::getInstance();
$notificationModel = new NotificationModel();

// Get the simulated customer ID from the session
$customerId = $_SESSION['customer_id'];

// Get the selected filter status from POST data
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';

try {
    // Fetch notifications for the specific customer
    $notifications = $notificationModel->getNotificationsByCustomerId($customerId);
    
    // Check if notifications were found
    if (!$notifications['success']) {
        throw new Exception($notifications['message']);
    }
    
    // Create XML
    $xml = new SimpleXMLElement('<notifications/>');
    foreach ($notifications['notifications'] as $notification) {
        $notif = $xml->addChild('notification');
        $notif->addChild('id', $notification['id']);
        $notif->addChild('customer_id', $notification['customer_id']);
        $notif->addChild('promotion_id', $notification['promotion_id']);
        $notif->addChild('message', $notification['message']);
        $notif->addChild('status', $notification['status']);
        $notif->addChild('created_at', $notification['created_at']);
    }

    // Save XML to a file in the 'xml' directory
    $xmlFile = '../xml/notification.xml';
    $xml->asXML($xmlFile);

    // Load XML and XSL files
    $xslFile = '../xml/notification.xsl'; // Ensure this path is correct

    if (!file_exists($xslFile)) {
        die("XSL file not found: $xslFile");
    }

    if (!file_exists($xmlFile)) {
        die("XML file not found: $xmlFile");
    }

    // Load XML into DOMDocument
    $xmlDoc = new DOMDocument;
    $xmlDoc->load($xmlFile);

    // Create a new DOMXPath object
    $xpath = new DOMXPath($xmlDoc);

    // Query for notifications with the selected status
    $query = $filter === 'all' ? '//notification' : "//notification[status='$filter']";
    $entries = $xpath->query($query);

    // Create a new XML document to store the filtered results
    $filteredXml = new DOMDocument;
    $filteredRoot = $filteredXml->createElement('notifications');
    $filteredXml->appendChild($filteredRoot);

    foreach ($entries as $entry) {
        $importedNode = $filteredXml->importNode($entry, true);
        $filteredRoot->appendChild($importedNode);
    }

    // Save the filtered XML
    $filteredXmlFile = '../xml/filtered_notification.xml';
    $filteredXml->save($filteredXmlFile);

    // Load filtered XML for transformation
    $filteredXmlDoc = new DOMDocument;
    $filteredXmlDoc->load($filteredXmlFile);

    // Configure the XSLT processor
    $xslDoc = new DOMDocument;
    $xslDoc->load($xslFile);

    $proc = new XSLTProcessor;
    $proc->importStylesheet($xslDoc);

    // Transform filtered XML to HTML
    $html = $proc->transformToXML($filteredXmlDoc);

} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notifications</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container for centering the content */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Button styling */
        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Filter form styling */
        .filter-form {
            margin-bottom: 20px;
        }

        .filter-form select {
            padding: 10px;
            font-size: 16px;
        }

        .filter-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Notifications</h1>
        
        <!-- Filter Form -->
        <form method="POST" class="filter-form">
            <label for="filter">Filter by Status:</label>
            <select name="filter" id="filter">
                <option value="sent" <?php if ($filter == 'sent') echo 'selected'; ?>>Sent</option>
                <option value="pending" <?php if ($filter == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <!-- Display transformed XML -->
        <?php
        echo $html;
        ?>

        <a href="index.php" class="btn">Back to Home</a>
    </div>
</body>
</html>
