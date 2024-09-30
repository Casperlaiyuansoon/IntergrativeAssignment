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
                        <a href="#">
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
                        <a href="adminorderhistory.php">
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


                <!-- ================================= Cards ================================= -->
                <div class="cardBox">
                    <div class="card">
                        <div>
                            <div class="numbers">1,504</div>
                            <div class="cardName">Daily View</div>
                        </div>

                        <div class="iconBx">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div>
                            <div class="numbers">80</div>
                            <div class="cardName">Sales</div>
                        </div>

                        <div class="iconBx">
                            <ion-icon name="cart-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div>
                            <div class="numbers">284</div>
                            <div class="cardName">Comments</div>
                        </div>

                        <div class="iconBx">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div>
                            <div class="numbers">7,842</div>
                            <div class="cardName">Earnning</div>
                        </div>

                        <div class="iconBx">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                    </div>
                </div>

                <!-- ================================= Order Detail list ================================= -->
                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Order </h2>
                            <a href="#" class="btn">View All</a>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Image</td>
                                    <td>Name</td>
                                    <td>Price</td>
                                    <td>Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Star Refrigerator</td>
                                    <td>$1200</td>
                                    <td>Paid</td>
                                    <td>Paid</td>
                                    <td><span class="status delivered">Delivered</span></td>
                                </tr>

                                <tr>
                                    <td>Dell laptop</td>
                                    <td>$110</td>
                                    <td>Due</td>
                                    <td><span class="status pending">Pending</span></td>
                                </tr>

                                <tr>
                                    <td>Aplle Watch</td>
                                    <td>$1200</td>
                                    <td>Paid</td>
                                    <td><span class="status return">Return</span></td>
                                </tr>

                                <tr>
                                    <td>Adidas Shoes</td>
                                    <td>$620</td>
                                    <td>Due</td>
                                    <td><span class="status inProgress">In Progress</span></td>
                                </tr>
                            </tbody>
                        </table>







                        <!-- =============== Scripts =============== -->
                        <script src="../../../public/js/adminmenu.js"></script>

                        <!-- =============== ionicons =============== -->
                        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
                        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
                        </body>
                        </html>

