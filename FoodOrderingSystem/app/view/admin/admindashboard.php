<?php
require_once '../../config/Database.php';
require_once '../../models/DashboardModel.php';
require_once '../../controller/DashboardController.php';

// Database connection
$database = new Database();
$model = new DashboardModel($database);
$controller = new DashboardController($model);
$data = $controller->getDashboardData();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/adminmenu.css">
    <link rel="stylesheet" href="../../../public/css/adminmenu2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="admindashboard.php">
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
                        <span class="icon"><ion-icon name="bag-remove-outline"></ion-icon></span>
                        <span class="title">Order</span>
                    </a>
                </li>
                <li>
                    <a href="../../view/view_notification.php">
                        <span class="icon"><ion-icon name="notifications-outline"></ion-icon></span>
                        <span class="title">Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="pricetag-outline"></ion-icon></span>
                        <span class="title">Promotion</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="ticket-outline"></ion-icon></span>
                        <span class="title">Voucher</span>
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
                <div class="user">
                    <img src="../../../public/image/review_1.png" alt="">
                </div>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $data['totalCustomers']; ?></div>
                        <div class="cardName">Total Customers</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $data['totalMenuItems']; ?></div>
                        <div class="cardName">Total Menu</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="fast-food-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $data['totalOrders']; ?></div>
                        <div class="cardName">Total Order</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="bag-remove-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">RM<?php echo number_format($data['totalSales'], 2); ?></div>
                        <div class="cardName">Total Sales</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================================= Chart ================================= -->
            <div class="chart-container"
                style="display: flex; justify-content: center; align-items: center; width: 100%; height: 510px; ">
                <canvas id="myChart"></canvas>
            </div>


            <!-- =============== Scripts =============== -->
            <script src="../../../public/js/adminmenu.js"></script>
            <script>
                // Data to be displayed in the chart
                const data = {
                    labels: ['Total Customers', 'Total Menu', 'Total Orders', 'Total Sales'],
                    datasets: [{
                        label: 'Statistics',
                        data: [<?php echo $data['totalCustomers']; ?>,
                            <?php echo $data['totalMenuItems']; ?>,
                            <?php echo $data['totalOrders']; ?>,
                            <?php echo $data['totalSales']; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 2
                    }]
                };

                // Configuration options
                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                // Rendering the chart
                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>



            <script src="../../../public/js/adminmenu.js"></script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        </div>
    </div>
</body>

</html>