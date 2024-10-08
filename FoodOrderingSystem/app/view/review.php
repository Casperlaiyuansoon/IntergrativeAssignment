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
                <a href="css/index.php">
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
                <a href="cart.php"><i class="fa-solid fa-heart"></i></a>
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="user_profile.php" id="profile-link"><i class="fa-solid fa-user"></i></a>
                <a href="view_notification_customer.php" id="profile-link"><i class="fa-solid fa-bell"></i></a>
            </div>

        </nav>
   
    </section>


<!--Review-->
    
<div class="review" id="Review">
    <h1>Customer<span>Review</span></h1>

    <div class="review_box">
        <div class="review_card">

            <div class="review_profile">
                <img src="../../public/image/review_1.png">
            </div>

            <div class="review_text">
                <h2 class="name">John Deo</h2>

                <div class="review_icon">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>

                <div class="review_social">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>

                <p>
                  "Amazing experience! The interface is super user-friendly, and I love how easy it is to customize my order. The food arrived on time, still hot and fresh. I’ll definitely be ordering again soon. Highly recommend!"
                </p>

            </div>

        </div>

        <div class="review_card">

            <div class="review_profile">
                <img src="../../public/image/review_2.png">
            </div>

            <div class="review_text">
                <h2 class="name">John Deo</h2>

                <div class="review_icon">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>

                <div class="review_social">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>

                <p>
  "Good selection of menu items and the delivery was fast. My only complaint is that the app froze once when I was trying to update my cart, but overall, a great experience. The lasagna was delicious!"
                </p>

            </div>

        </div>

        <div class="review_card">

            <div class="review_profile">
                <img src="../../public/image/review_3.png">
            </div>

            <div class="review_text">
                <h2 class="name">John Deo</h2>

                <div class="review_icon">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>

                <div class="review_social">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>

                <p>
"This is my go-to food ordering app. I love the variety of options, from healthy meals to comfort food. The tracking system is accurate, and the customer service is excellent. The salmon steak was perfectly cooked!"
                </p>

            </div>

        </div>

        <div class="review_card">

            <div class="review_profile">
                <img src="../../public/image/review_4.png">
            </div>

            <div class="review_text">
                <h2 class="name">John Deo</h2>

                <div class="review_icon">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>

                <div class="review_social">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>

                <p>
"The ordering process was smooth, but I wasn’t too happy with the portion sizes for the price. The burger was tasty but a bit small. Delivery was prompt, though, and the support team was responsive when I had questions."
                </p>

            </div>

        </div>

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

        <p class="end"><span><i class="fa-solid fa-face-grin"></i> EasyFood</span></p>

    </footer>



    
</body>
</html>