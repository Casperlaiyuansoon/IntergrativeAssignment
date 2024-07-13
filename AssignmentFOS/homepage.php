<!DOCTYPE html>

<style>
body{
    width: 100%;
    position: absolute;
}

.image-slider{
    width: 95%;
    height: 700px;
    padding: 20px;
    margin: auto;
    margin-top: 10px;
    border: 1px solid black;
}

.slide img{
    margin: auto;
    padding: 20px;
    position: relative;
}

.slide{
    display: block;
}

.description{
    padding: 50px;
    margin: auto;
    height: 300px;
}

footer {
    width: 99%;
    height: 100px;
    background-color: darkorange;
    color: #fff;
    padding: 10px;
    text-align: center;
    margin-top: 20px;
    position: relative;
}
</style>

<?php include "default-nav.php"; ?>

<html>
    <title>Home</title>

    <body>

        <div class="image-slider">
            <div class="slide">
            <img src="images/Ragdoll-Cat.jpg" alt="" style="width:75%">
            </div>
        </div>

        <div class="description">
            <h3>Food Menu</h3>
            <h3>Payment Details</h3>
            <h3>Food Menu</h3>
            <h3>Payment Details</h3>
        </div>

        <footer>
            <h2>&copy; 2024 Food Ordering System</h2>
        </footer>
    </body>
</html>