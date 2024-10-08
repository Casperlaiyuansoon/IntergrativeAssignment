<?php
require_once '../../controller/FoodController.php';
require_once '../../models/Food.php';

// Get the search term if provided
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;

// Fetch all food items based on search term
if ($searchTerm) {
    $foodItems = $food->searchByName($searchTerm)->fetchAll(PDO::FETCH_ASSOC);
} else {
    $foodItems = $food->read()->fetchAll(PDO::FETCH_ASSOC);
}

// Generate XML dynamically
$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="menu.xsl"?><orders/>');
foreach ($foodItems as $item) {
    $food = $xml->addChild('order');
    $food->addAttribute('id', $item['id']);
    $food->addChild('name', $item['name']);
    $food->addChild('price', $item['price']);
    $food->addChild('image', $item['image']);
}

// Save the XML file
$xml->asXML('menu.xml');

// Apply XSLT transformation
class XSLTTransformation {
    public function __construct($xmlfilename, $xslfilename) {
        $xml = new DOMDocument();
        $xml->load($xmlfilename);

        $xsl = new DOMDocument();
        $xsl->load($xslfilename);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);

        echo $proc->transformToXml($xml);
    }
}

// Call the XSLT transformation
$worker = new XSLTTransformation("menu.xml", "menu.xsl");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Food Website</title>
    <link rel="stylesheet" href="../../../public/css/style.css" />
    <link rel="stylesheet" href="../../../public/css/menu.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<body>
    <section id="Home">
        <nav>
            <div class="logo">
                <a href="../homepage.php">
                    <img src="../../../public/image/logo.png" />
                </a>
            </div>
            <ul>
                <li><a href="../homepage.php">Home</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="../OrderHistory.php">Order History</a></li>
                <li><a href="../review.php">Review</a></li>
                <li><a href="../contactUs.php">Contact Us</a></li>
            </ul>

            <div class="icon">
                <a href="cart.php"><i class="fa-solid fa-heart"></i></a>
                <a href="../../view/AddToCartView.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        </nav>
    </section>

    <!--Menu-->
    <div class="menu" id="Menu">
        <h1>Our<span>Menu</span></h1>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="menu.php" method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Search for food..." value="<?php echo htmlspecialchars($searchTerm); ?>" />
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
            </form>
        </div>

        <div class="menu_box">
            <?php if (!empty($foodItems)): ?>
                <?php foreach ($foodItems as $item): ?>
                    <div class="menu_card">
                        <div class="menu_image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" />
                        </div>

                        <div class="small_card">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <form method="post" action="/FoodOrderingSystem/app/controller/AddToCartControl.php">
                        <div class="menu_info">
                            <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                            <h3>RM<?php echo htmlspecialchars($item['price']); ?></h3>
                            <div class="menu_icon">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </div>

                            <!-- Add to Cart Button -->
                            <input type="hidden" name="ProductID" value="<?php echo htmlspecialchars($item['id']); ?>" />
                            <input type="hidden" name="ProductPrice" value="<?php echo htmlspecialchars($item['price']); ?>" />
                            <input type="submit" name="AddToCart" value="Add Now" class="menu_btn"/>
                        </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items found for your search query.</p>
            <?php endif; ?>
        </div>
    </div>

    <!--Footer-->
    <footer>
        <div class="footer_main">
            <div class="footer_tag">
                <h2>Location</h2>
                <p>Sri Lanka</p>
                <p>USA</p>
                <p>India</p>
                <p>Japan</p>
                <p>Italy</p>
            </div>

            <div class="footer_tag">
                <h2>Quick Link</h2>
                <p>Home</p>
                <p>About</p>
                <p>Menu</p>
                <p>Gallery</p>
                <p>Order</p>
            </div>

            <div class="footer_tag">
                <h2>Contact</h2>
                <p>+94 12 3456 789</p>
                <p>+94 25 5568456</p>
                <p>johndeo123@gmail.com</p>
                <p>foodshop123@gmail.com</p>
            </div>

            <div class="footer_tag">
                <h2>Our Service</h2>
                <p>Fast Delivery</p>
                <p>Easy Payments</p>
                <p>24 x 7 Service</p>
            </div>

            <div class="footer_tag">
                <h2>Follow Us</h2>
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-linkedin-in"></i>
            </div>
        </div>

        <p class="end">
            <span><i class="fa-solid fa-face-grin"></i> EasyFood</span>
        </p>
    </footer>
</body>
</html>
