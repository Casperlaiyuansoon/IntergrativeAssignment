<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<section id="Home">
        <nav>
            <div class="logo">
                <a href="homepage.php">
                    <img src="image/logo.png">
                </a>
            </div>

            <ul>
                <li><a href="/FoodOrderingSystem/Public/homepage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="/FoodOrderingSystem/Public/menu.php">Menu</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
                <li><a href="PaymentHistory.php">Payment History</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
            </ul>

            <div class="icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <!-- <a href="cart.php"><i class="fa-solid fa-heart"></i></a> --->
                <a href="/FoodOrderingSystem/Public/AddToCartView.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>

            <div class="login">
            <a href="login.php">Login</a>
            </div>
        </nav></br></br></br></br></br></br></br>
<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "test1";

$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

session_start();

//$_SESSION['email'] = "zy@gmail.com";
$email = $_SESSION['email'];

$sql = "SELECT P.PAYMENTID, P.USEREMAIL, P.PAYMENTAMOUNT, P.PAYMENTMETHOD, P.PAYMENTTIME FROM PAYMENT P WHERE P.USEREMAIL = '$email'";
$result = $db->query($sql);
//$result->execute();

$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="PaymentHistory.xsl"?><payments/>');
//$pi = $xml->addProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="OrderHistory.xsl"');

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

        $order = $xml->addChild('payment');
        $order->addAttribute('id', $row['PAYMENTID']);
        $order->addChild('amount', $row['PAYMENTAMOUNT']);
        $order->addChild('method', $row['PAYMENTMETHOD']);
        $order->addChild('payment_date', $row['PAYMENTTIME']);
    }
}

//XSLT Process
$xmlfilename = "PaymentHistory.xml";
$xslfilename = "PaymentHistory.xsl";

$xml->asXML($xmlfilename);

$xml = new DOMDocument();
$xml->load($xmlfilename);

$xsl = new DOMDocument();
$xsl->load($xslfilename);

$proc = new XSLTProcessor;
$proc->importStylesheet($xsl);

echo $proc->transformToXml($xml);

?>
        </section>
</body>