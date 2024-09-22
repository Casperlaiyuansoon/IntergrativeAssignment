<?php
session_start();
include_once '../models/VoucherModel.php';
include_once '../models/DatabaseConnection.php';

$conn = DatabaseConnection::getInstance();
$voucherModel = new VoucherModel();
$vouchers = $voucherModel->getAllVouchers($conn);

// Generate XML from vouchers
$xmlData = $voucherModel->vouchersToXML($vouchers);

// Load the XSLT file
$xsl = new DOMDocument();
$xsl->load('../xml/voucher.xsl'); // Adjust the path as necessary

// Load the XML data
$xml = new DOMDocument();
$xml->loadXML($xmlData);

// Create the XSLT processor
$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);

// Transform XML to HTML
$htmlOutput = $proc->transformToXML($xml);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vouchers</title>
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

        .add-voucher-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin-bottom: 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .add-voucher-btn:hover {
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

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        a:hover {
            color: #3e8e41;
        }

        .delete-btn {
            color: white;
            background-color: #f44336;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        form {
            display: inline;
        }
    </style>
</head>
<body>
    <h1>View Vouchers</h1>
    
    <a href="generate_voucher.php" class="add-voucher-btn">Generate New Voucher</a>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Promotion ID</th>
                <th>Expiration Date</th>
                <th>Discount (%)</th>
                <th>Max Uses</th>
                <th>Times Used</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vouchers)): ?>
                <?php foreach ($vouchers as $voucher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['code']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['promotion_id']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['expiration_date']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['discount_percentage']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['max_uses']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['times_used']); ?></td>
                        <td>
                            <form method="POST" action="../controllers/VoucherController.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $voucher['id']; ?>">
                                <input type="submit" name="delete_voucher" value="Delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this voucher?');">
                            </form>
                            <a href="edit_voucher.php?id=<?php echo $voucher['id']; ?>" class="edit-btn">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No vouchers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
