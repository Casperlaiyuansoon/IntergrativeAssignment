<?php
include_once '../models/PromotionModel.php';
include_once '../config/database.php';

$db = new Database();
$conn = $db->getConnection();
$promotionModel = new PromotionModel();
$promotions = $promotionModel->getAllPromotions($conn);

// Create an XML document
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

// Create root element <promotions>
$root = $xml->createElement('promotions');
$xml->appendChild($root);

// Add promotion data to the XML document
foreach ($promotions as $promotion) {
    $promotionElement = $xml->createElement('promotion');

    $id = $xml->createElement('id', $promotion['id']);
    $promotionElement->appendChild($id);

    $title = $xml->createElement('title', htmlspecialchars($promotion['title']));
    $promotionElement->appendChild($title);

    $description = $xml->createElement('description', htmlspecialchars($promotion['description']));
    $promotionElement->appendChild($description);

    $discount = $xml->createElement('discount_percentage', htmlspecialchars($promotion['discount_percentage']));
    $promotionElement->appendChild($discount);

    $startDate = $xml->createElement('start_date', htmlspecialchars($promotion['start_date']));
    $promotionElement->appendChild($startDate);

    $endDate = $xml->createElement('end_date', htmlspecialchars($promotion['end_date']));
    $promotionElement->appendChild($endDate);

    $root->appendChild($promotionElement);
}

// Save XML to a file
$xmlFilePath = '../xmlandxslt/promotions.xml';
$xml->save($xmlFilePath);

// Load the XML file
$xmlDoc = new DOMDocument();
$xmlDoc->load($xmlFilePath);

// Create a new XPath object
$xpath = new DOMXPath($xmlDoc);

// Initialize search and sort parameters
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'start_date';

// Select promotions based on search query
if (!empty($searchQuery)) {
    $searchQuery = htmlspecialchars($searchQuery);
    $searchPromotions = $xpath->query("/promotions/promotion[contains(title, '$searchQuery') or contains(description, '$searchQuery')]");
} else {
    $searchPromotions = $xpath->query("/promotions/promotion");
}

// Sort the promotions if required
$sortedArray = iterator_to_array($searchPromotions);
usort($sortedArray, function ($a, $b) use ($xpath, $sortBy) {
    $dateA = $xpath->query($sortBy, $a)->item(0)->nodeValue;
    $dateB = $xpath->query($sortBy, $b)->item(0)->nodeValue;
    return strtotime($dateA) - strtotime($dateB);

    
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Promotions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f0f4f8;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .add-promotion-btn {
            display: inline-block;
            background-color:  #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin-bottom: 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .add-promotion-btn:hover {
            background-color: #0056b3;
        }

        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .sort-container {
            text-align: center;
            margin: 20px 0;
        }

        .sort-select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            background-color:  #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        .delete-btn {
            color: white;
            background-color: #dc3545;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        form {
            display: inline;
        }
        .back-home-btn {
    display: inline-block;
    background-color: #008CBA;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    font-size: 16px;
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
    <h1>Current Promotions</h1>
    <a href="add_promotion.php" class="add-promotion-btn">Add New Promotion</a>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" class="search-input" placeholder="Search promotions..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="Search" class="search-btn">
        </form>
    </div>

    <div class="sort-container">
        <form method="GET" action="">
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <label for="sort">Sort By:</label>
            <select name="sort" id="sort" class="sort-select" onchange="this.form.submit()">
                <option value="start_date" <?php echo $sortBy == 'start_date' ? 'selected' : ''; ?>>Start Date</option>
                <option value="end_date" <?php echo $sortBy == 'end_date' ? 'selected' : ''; ?>>End Date</option>
            </select>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Discount (%)</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sortedArray as $promotion): ?>
                <tr>
                    <td><?php echo $xpath->query('title', $promotion)->item(0)->nodeValue; ?></td>
                    <td><?php echo $xpath->query('description', $promotion)->item(0)->nodeValue; ?></td>
                    <td><?php echo $xpath->query('discount_percentage', $promotion)->item(0)->nodeValue; ?></td>
                    <td><?php echo $xpath->query('start_date', $promotion)->item(0)->nodeValue; ?></td>
                    <td><?php echo $xpath->query('end_date', $promotion)->item(0)->nodeValue; ?></td>
                    <td>
                        <a href="edit_promotion.php?id=<?php echo $xpath->query('id', $promotion)->item(0)->nodeValue; ?>">Edit</a>
                        <form method="POST" action="../controller/PromotionControllers.php" onsubmit="return confirm('Are you sure you want to delete this promotion?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $xpath->query('id', $promotion)->item(0)->nodeValue; ?>">
                            <input type="submit" name="delete_promotion" value="Delete" class="delete-btn">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="homepage.php" class="back-home-btn">Back to Home</a>
     <!-- Back Button -->
     <a href="user.php" class="btn-back">Back</a>
</body>
</html>
