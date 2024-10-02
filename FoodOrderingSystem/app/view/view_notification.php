<?php
include_once '../models/NotificationModel.php';
include_once '../config/database.php';

// Create a connection instance
$db = new Database();
$conn = $db->getConnection();
$notificationModel = new NotificationModel();

// Get the selected filter status from POST data
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';

try {
    // Fetch all notifications
    $notifications = $notificationModel->getAllNotifications();

    // Create XML
    $xml = new SimpleXMLElement('<notifications/>');
    foreach ($notifications as $notification) {
        $notif = $xml->addChild('notification');
        $notif->addChild('id', $notification['id']);
        $notif->addChild('user_id', $notification['user_id']);
        $notif->addChild('promotion_id', $notification['promotion_id']);
        $notif->addChild('message', $notification['message']);
        $notif->addChild('status', $notification['status']);
        $notif->addChild('created_at', $notification['created_at']);
    }

    // Save XML to a file in the 'xml' directory
    $xmlFile = '../xmlandxslt/notification.xml';
    $xml->asXML($xmlFile);

    // Load XML and XSL files
    $xslFile = '../xmlandxslt/notification.xsl'; // Ensure this path is correct

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
    $filteredXmlFile = '../xmlandxslt/filtered_notification.xml';
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
        /* ... (previous styles remain unchanged) ... */

        /* Add styles for Edit and Delete buttons */
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #ffc107;
            color: #000;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>View Notifications</h1>

        <!-- Create Notification Button -->
        <div class="create-btn">
            <a href="create_notification.php" class="btn">Create Notification</a>
        </div>

        <!-- Filter Form -->
        <form method="POST" class="filter-form">
            <label for="filter">Filter by Status:</label>
            <select name="filter" id="filter">
                <option value="active" <?php if ($filter == 'active')
                    echo 'selected'; ?>>Active</option>
                <option value="pending" <?php if ($filter == 'pending')
                    echo 'selected'; ?>>Pending</option>
                <option value="all" <?php if ($filter == 'all')
                    echo 'selected'; ?>>All</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <!-- Display transformed XML -->
        <div id="notifications-container">
            <?php
            // Modify the HTML output to include Edit and Delete buttons
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // Find all table rows
            $rows = $xpath->query('//tr');

            // Skip the first row (header) and process the rest
            for ($i = 1; $i < $rows->length; $i++) {
                $row = $rows->item($i);
                $cells = $xpath->query('.//td', $row);

                // Check if the row has cells before proceeding
                if ($cells->length > 0) {
                    $idCell = $cells->item(0);

                    // Check if the ID cell exists and has a value
                    if ($idCell && $idCell->nodeValue) {
                        $id = $idCell->nodeValue;

                        $actionsCell = $dom->createElement('td');

                        $editBtn = $dom->createElement('button', 'Edit');
                        $editBtn->setAttribute('class', 'action-btn edit-btn');
                        $editBtn->setAttribute('onclick', "editNotification($id)");

                        $deleteBtn = $dom->createElement('button', 'Delete');
                        $deleteBtn->setAttribute('class', 'action-btn delete-btn');
                        $deleteBtn->setAttribute('onclick', "deleteNotification($id)");

                        $actionsCell->appendChild($editBtn);
                        $actionsCell->appendChild($deleteBtn);

                        $row->appendChild($actionsCell);
                    }
                }
            }

            // Add the 'Actions' header to the first row
            $headerRow = $rows->item(0);
            if ($headerRow) {
                $actionsHeader = $dom->createElement('th', 'Actions');
                $headerRow->appendChild($actionsHeader);
            }

            echo $dom->saveHTML();
            ?>
        </div>

        <a href="index.php" class="btn">Back to Home</a>
    </div>

    <script>
        function editNotification(id) {
            // Redirect to edit page or open a modal for editing
            window.location.href = `edit_notification.php?id=${id}`;
        }

        function deleteNotification(id) {
            if (confirm('Are you sure you want to delete this notification?')) {
                fetch('delete_notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Notification deleted successfully');
                            // Reload the page or remove the row from the table
                            location.reload();
                        } else {
                            alert('Failed to delete notification');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the notification');
                    });
            }
        }
    </script>
</body>

</html>