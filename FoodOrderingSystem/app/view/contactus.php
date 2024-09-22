<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>    
    
    <section id="Home">
        <nav>
            <div class="logo">
                <a href="homepage.html">
                <img src="../../public/image/logo.png">
                </a>
            </div>

           <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
            </ul>

            <div class="icon">
                <a href="cart.php"><i class="fa-solid fa-heart"></i></a>
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>

        </nav>
   
    </section>



<!--Order-->

 <div class="order" id="Order">
    <h1><span>Contact Us</span>Now</h1>

    <div class="order_main">

        <div class="order_image">
            <img src="../../public/image/order_image.png">
        </div>

        <form action="#">

            <div class="input">
                <p>Name</p>
                <input type="text" placeholder="you name">
            </div>

            <div class="input">
                <p>Email</p>
                <input type="email" placeholder="you email">
            </div>

            <div class="input">
                <p>Phone Number</p>
                <input placeholder="you phone Number">
            </div>

            <div class="input">
                <p>Address</p>
                <input placeholder="you address">
            </div>

            <div class="input">
                <p>Feedback</p>
                <input placeholder="you feedback">
            </div>

            <a href="#" class="order_btn">Submit Now</a>

        </form>
        

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