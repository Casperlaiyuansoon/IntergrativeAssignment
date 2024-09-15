<?php 
require_once '../../controller/FoodController.php';


// Fetch all food items
$foodItems = $food->read()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
    <h1>Menu</h1>
    <ul>
        <?php foreach ($foodItems as $item): ?>
            <li>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p>Price: <?php echo htmlspecialchars($item['price']); ?></p>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 200px; height: auto;"> 
                
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
