<?php
session_start();

// Define the checkSessionTimeout function
function checkSessionTimeout()
{
    $timeout_duration = 1800; // Set the session timeout duration (30 minutes)

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: login.php?session_expired=true");
        exit();
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>You are not logged in. Please log in to access more features.</p>";
}

// Check if the session has timed out
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <li><a href="homepage.php">Home</a></li>
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
                <a href="user_profile.php" id="profile-link"><i class="fa-solid fa-user"></i></a>
            </div>

            <!-- <div class="login">
            <a href="login.php">Login</a>
            </div> -->
            <div class="login">
                <?php
                if (isset($_SESSION['user_id'])): ?>
                    <a href="../controller/logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>

        </nav>

        <div class="main">

            <div class="men_text">
                <h1>Get Fresh<span>Food</span><br>in a Easy Way</h1>
            </div>

            <div class="main_image">
                <img src="image/main_img.png">
            </div>

        </div>

        <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Esse reiciendis quaerat nobis
            deleniti amet non inventore. Reprehenderit recusandae voluptatibus minus tenetur itaque numquam
            cum quos dolorem maxime. Quas, quaerat nisi. Lorem ipsum dolor sit, amet consectetur adipisicing
            elit. Cumque facilis, quaerat cupiditate nulla quibusdam quo sunt esse tempore inventore vel
            voluptate, amet laudantium adipisci veniam nihil quam molestiae omnis mollitia.
        </p>

        <div class="main_btn">
            <a href="menu.php">Order Now</a>
            <i class="fa-solid fa-angle-right"></i>
        </div>

    </section>



    <!--About-->

    <div class="about" id="About">
        <div class="about_main">

            <div class="image">
                <img src="image/Food-Plate.png">
            </div>

            <div class="about_text">
                <h1><span>About</span>Us</h1>
                <h3>Why Choose us?</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Expedita, est. Doloremque
                    sapiente veritatis laboriosam corrupti optio et maxime. Ad, amet explicabo eaque labore
                    cupiditate quasi nostrum nemo recusandae id quibusdam? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Doloremque ab, dolores pariatur cum exercitationem, illo nisi
                    veritatis vitae ea deleniti fugiat quisquam tempora, accusantium corrupti excepturi optio.
                    Inventore, cupiditate recusandae.
                </p>
            </div>

        </div>

        <a href="menu.php" class="about_btn">Order Now</a>

    </div>


    <!--Gallary-->

    <div class="gallary" id="Gallary">
        <h1>Our<span>Gallary</span></h1>

        <div class="gallary_image_box">
            <div class="gallary_image">
                <img src="image/gallary_1.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="menu.html" class="gallary_btn">Order Now</a>
            </div>

            <div class="gallary_image">
                <img src="image/gallary_2.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="Menu.html" class="gallary_btn">Order Now</a>
            </div>

            <div class="gallary_image">
                <img src="image/gallary_3.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="menu.php" class="gallary_btn">Order Now</a>
            </div>

            <div class="gallary_image">
                <img src="image/gallary_4.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="menu.php" class="gallary_btn">Order Now</a>
            </div>

            <div class="gallary_image">
                <img src="image/gallary_5.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="menu.html" class="gallary_btn">Order Now</a>
            </div>

            <div class="gallary_image">
                <img src="image/gallary_6.jpg">

                <h3>Food</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi sint eveniet laboriosam
                </p>
                <a href="Menu.php" class="gallary_btn">Order Now</a>
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

        <p class="end">
            <span><i class="fa-solid fa-face-grin"></i> EasyFood</span>
        </p>

    </footer>




</body>

</html>