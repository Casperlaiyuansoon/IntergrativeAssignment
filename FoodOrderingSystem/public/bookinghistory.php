<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bookinghistory.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>    
    
    <section id="Home">
        <nav>
            <div class="logo">
                <a href="index.html">
                    <img src="image/logo.png">
                </a>
            </div>

           <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="bookingHistory.php">Booking History</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
            </ul>

            <div class="icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <a href="cart.php"><i class="fa-solid fa-heart"></i></a>
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>

        </nav>
   
    </section>
    

     <!--Booking History-->

    <div class="table">
        <div class="table_header">
            <h1><span>Contact Us</span>Now</h1>
            <div>
                <input placeholder="Food"/>
                <button class="search">Search</button>
            </div>
        </div>

        <div class="table_section">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Food</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td><img src="image/lasagna.webp"> </td>
                        <td>Lagsana</td>
                        <td>2</td>
                        <td>Rm10</td>
                        <td>
                            <button><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td><img src="image/pasta.jpg"> </td>
                        <td>Paste</td>
                        <td>1</td>
                        <td>Rm10</td>
                        <td>
                            <button><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td><img src="image/salmonsteak.jpg"> </td>
                        <td>Salmon Steak</td>
                        <td>3</td>
                        <td>Rm10</td>
                        <td>
                            <button><i class="fa-solid fa-eye"></i></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td><img src="image/sandwich.jpg"> </td>
                        <td>Sandwhich</td>
                        <td>4</td>
                        <td>Rm10</td>
                        <td>
                            <button><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                    <p>Gallary</p>
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
                    <h2>Follows</h2>
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>
    
            </div>
    
            <p class="end">
                <span
               ><i class="fa-solid fa-face-grin"></i> EasyFood</span
             >
           </p>
    
        </footer>
    
    
    
        
    </body>
    </html>