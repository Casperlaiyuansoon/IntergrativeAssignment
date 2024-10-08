<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order</title>
        <!-- ===== Style ===== -->
        <link rel="stylesheet" href="../../../public/css/adminmenu.css">
        <link rel="stylesheet" href="../../../public/css/adminmenu2.css">
    </head>

    <body>
        <!-- ================== Navigation ========================== -->
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon"><img src="../../../public/image/logo.png"></span>
                            <span class="title">Ordering System</span>
                        </a>
                    </li>
                    <li>
                        <a href="admindashboard.php">
                            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../view/user.php">
                            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                            <span class="title">User</span>
                        </a>
                    </li>
                    <li>
                        <a href="adminmenu.php">
                            <span class="icon"><ion-icon name="fast-food-outline"></ion-icon></span>
                            <span class="title">Menu</span>
                        </a>
                    </li>
                    <li>
                        <a href="adminorder.php">
                            <span class="icon"><ion-icon name="bag-remove-outline"></ion-icon></ion-icon></span>
                            <span class="title">Order</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../controller/adminLogout.php">
                            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                            <span class="title">Sign Out</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ================================= Main ================================= -->
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>
                    <div class="search">
                        <label>
                            <input type="text" id="searchInput" placeholder="Search here" onkeyup="filterTable()">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div>
                    <div class="user">
                        <img src="../../../public/image/review_1.png" alt="">
                    </div>
                </div>

                <!-- ================================= Order Detail list ================================= -->
                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Order List</h2>
                            <a href="#" class="btn">View All</a>
                        </div>

                        <?php
                        require_once "C:/xampp/htdocs/FoodOrderingSystem/app/config/Database.php";

                        $database = new Database();
                        // Get the database connection
                        $db = $database->getConnection();

                        // Fetch orders from the database
                        $query = "SELECT o.id, om.ORDERID, om.UserEmail, om.OrderAmount, om.OrderCreation, om.OrderStatus FROM orders o, ordermain om";
                        $result = $db->prepare($query);
                        $result->execute();

                        $xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="adminorder.xsl"?><orders/>');

                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $order = $xml->addChild('order');
                            $order->addAttribute('id', $row['ORDERID']);
                            $order->addChild('user', $row['UserEmail']);
                            $order->addChild('amount', $row['OrderAmount']);
                            $order->addChild('time', $row['OrderCreation']);
                            $order->addChild('status', $row['OrderStatus']);
                        }

                        // Save XML to file
                        $xml->asXML('adminorder.xml');
                        ?>

                        <?php

                        // XSLT Process
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

                        $worker = new XSLTTransformation("adminorder.xml", "adminorder.xsl");
                        ?>

                        <!-- =============== Scripts =============== -->
                        <script src="../../../public/js/adminmenu.js"></script>

                        <!-- =============== ionicons =============== -->
                        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
                        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

                        <script>
                                function filterTable() {
                                    const input = document.getElementById('searchInput');
                                    const filter = input.value.toLowerCase();
                                    const table = document.querySelector('table');
                                    const tr = table.getElementsByTagName('tr');

                                    // Loop through all table rows (except the first, which is the header)
                                    for (let i = 1; i < tr.length; i++) {
                                        const td = tr[i].getElementsByTagName('td');
                                        let rowVisible = false;

                                        // Loop through all cells in the row
                                        for (let j = 0; j < td.length; j++) {
                                            if (td[j]) {
                                                const txtValue = td[j].textContent || td[j].innerText;
                                                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                                    rowVisible = true;
                                                    break; // No need to check other cells
                                                }
                                            }
                                        }

                                        // Show or hide the row based on the search input
                                        tr[i].style.display = rowVisible ? '' : 'none';
                                    }
                                }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
