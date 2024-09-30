<?php
// Send a GET request to the Supplier API
$apiUrl = 'http://localhost:8080/api/suppliers'; // Ensure this matches your Spring Boot app
$response = file_get_contents($apiUrl);
$suppliers = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supplier Information</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Supplier Information</h2>
    <?php if ($suppliers && count($suppliers) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Name</th>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['id']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['name']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['product']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['stock']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No supplier information available.</p>
    <?php endif; ?>
</body>
</html>


