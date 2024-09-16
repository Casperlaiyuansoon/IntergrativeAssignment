

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reponsive Admin Dashbroad</title>
        <!-- ===== Style ===== -->
        <link rel="stylesheet" href="css/adminmenu.css">
    </head>

    <body>
        <!-- ================== Navigation ========================== -->
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="logo-apple"></ion-icon></span>
                            <span class="title">Food Ordeing Dashbroad</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                            <span class="title">Dashbroad</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                            <span class="title">Customers</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="chatbubbles-outline"></ion-icon></span>
                            <span class="title">Menu</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="help-outline"></ion-icon></span>
                            <span class="title">Help</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                            <span class="title">Setting</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                            <span class="title">Password</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
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
                           <input type="text" placeholder="Search here"></input>
                           <ion-icon name="search-outline"></ion-icon>
                        </label>
                     </div>

                     <div class="user">
                        <img src="image/Customer1.jpeg" alt="">
                     </div>
                 </div>
            

   

         <!-- ================================= Order Detail list ================================= -->
               <div class="details">
                 <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Food Menu</h2>
                        <a href="#" class="btn">Create Food</a>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Image</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Price</td>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Aplle Watch</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                
                                
                            </tr>

                        </tbody>
                    </table>


        <!-- =============== Scripts =============== -->
        <script src="js/adminmenu.js"></script>

        <!-- =============== ionicons =============== -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>

