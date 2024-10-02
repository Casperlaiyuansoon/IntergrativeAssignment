<?php
// URL of the Java Spring Boot REST API
$apiUrl = 'http://localhost:8080/api/inventory';

// Initialize cURL session
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$inventoryItems = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supplier Inventory</title>
</head>
<body>
    <h1>Supplier Inventory</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity Available</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($inventoryItems) && count($inventoryItems) > 0): ?>
                <?php foreach ($inventoryItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No inventory data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <a href="adminmenu.php" class="btn">Back to Admin Menu</a>
</body>
</html>
