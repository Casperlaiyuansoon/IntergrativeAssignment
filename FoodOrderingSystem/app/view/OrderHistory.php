<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section id="Home">
        <nav>
            <div class="logo">
                <a href="homepage.php">
                    <img src="../../public/image/logo.png">
                </a>
            </div>

            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="admin/menu.php">Menu</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
            </ul>

            <div class="icon">
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

        $sql = "SELECT OM.ORDERID, OM.ORDERCREATION, OM.USEREMAIL, P.ID, O.PRODUCTID, P.PRODUCTNAME, O.ORDERPRICE, O.ORDERQUANTITY FROM ORDERMAIN OM, ORDERITEM O, PRODUCT P WHERE OM.USEREMAIL = '$email' AND P.ID = O.PRODUCTID AND O.ORDERID = OM.ORDERID";
        $result = $db->query($sql);
//$result->execute();

        $xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="OrderHistory.xsl"?><orders/>');
//$pi = $xml->addProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="OrderHistory.xsl"');

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $order = $xml->addChild('order');
                $order->addAttribute('id', $row['ORDERID']);
                $order->addChild('product', $row['PRODUCTNAME']);
                $order->addChild('quantity', $row['ORDERQUANTITY']);
                $order->addChild('price', $row['ORDERPRICE']);
                $order->addChild('order_date', $row['ORDERCREATION']);
            }
        }

//XSLT Process
        $xmlfilename = "OrderHistory.xml";
        $xslfilename = "OrderHistory.xsl";

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