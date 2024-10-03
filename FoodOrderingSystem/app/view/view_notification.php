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
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .create-btn {
            margin-bottom: 20px;
        }

        .create-btn a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .create-btn a:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

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
            text-decoration: none;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .back-home-btn {
            display: inline-block;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .back-home-btn:hover {
            background-color: #007B9A;
        }

        .btn-back {
    display: inline-block;
    background-color: #6c757d; /* Grey background */
    color: #fff; /* White text */
    text-align: center;
    padding: 10px 15px;
    border-radius: 4px;
    text-decoration: none; /* Remove underline */
    font-size: 16px;
    margin-top: 10px;
    transition: background-color 0.3s; /* Smooth transition */
}

.btn-back:hover {
    background-color: #5a6268; /* Darker grey on hover */
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
                <option value="sent" <?php if ($filter == 'sent') echo 'selected'; ?>>Active</option>
                <option value="pending" <?php if ($filter == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
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

                        

                        // Create Edit link
                        $editLink = $dom->createElement('a', 'Edit');
                        $editLink->setAttribute('href', "edit_notification.php?id=$id");
                        $editLink->setAttribute('class', 'action-btn edit-btn');

                        // Create Delete button
                        $deleteBtn = $dom->createElement('button', 'Delete');
                        $deleteBtn->setAttribute('class', 'action-btn delete-btn');
                        $deleteBtn->setAttribute('onclick', "deleteNotification($id)");

                        // Append Edit link and Delete button to actions cell
                        $actionsCell->appendChild($editLink);
                        $actionsCell->appendChild($deleteBtn);

                        // Append actions cell to the current row
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

        <a href="homepage.php" class="back-home-btn">Back to Home</a>
        <!-- Back Button -->
        <a href="user.php" class="btn-back">Back</a>
    </div>
    

    <script>
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
                            alert('Notification deleted successfully.');
                            location.reload(); // Reload the page to reflect the changes
                        } else {
                            alert('Failed to delete notification: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('An error occurred while deleting the notification: ' + error);
                    });
            }
        }
    </script>
</body>
</html>
