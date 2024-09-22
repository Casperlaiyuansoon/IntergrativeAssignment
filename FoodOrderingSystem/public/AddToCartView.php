<!DOCTYPE html>

<?php 
require "C:/xampp/htdocs/FoodOrderingSystem/app/controller/AddToCartControl.php";

?>

<style>
    img{
        width: 100%;
    }
    .quantity-amount{
        width: 100px;
        color: black;

    }

    .quantity-amount input{
        padding: 1px;
    }

    input{
        padding: 10px;
    }

    .btn{
        margin-right: 10px;
        padding: 10px;
        width: 160px;
    }

    .increase{
        background-color: yellow;
    }

    .b1{
        background-color: darkolivegreen;
    }

    .b2, .close{
        background-color: red;
    }

    .close{
        float: right;
    }

    a{
        text-decoration: none;
        padding: 10px;
        width: 280px;
        color: white;
    }

</style>
<html>

<head>
<meta charset="UTF-8">
    <meta http-euiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add To Cart</title>
    <link rel="stylesheet" href="css/cart.css"/>
    <link rel="stylesheet" href="cart.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<h3 class="carttotal"></h3>

<div class="table">
    <div class="table_header">
        <p>Cart Details</p>
        <div>
            <input placeholder="Food"/>
            <button class="search">Search</button>
        </div>
    </div>
</div></br></br>

<div class="table_section">

            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                
                <tbody>

<?php
if(is_null($CartArr)){
    echo " ";
}

else{
    foreach($CartArr as $cart){

?>
        <tr>
            <td>
                <img src="/FoodOrderingSystem/app/Public/image/<?= $cart->getImage() ?>" alt="productImage" />
            </td>

            <td>
                <h3><?= $cart->getProductName() ?></h3>
            </td>

            <td>
                <h3><?= $cart->getPrice() ?></h3>
            </td>

            <td>
            <form method="post" action="/FoodOrderingSystem/app/controller/AddToCartControl.php">
            <div class="quantity">
                <button type="button" class="decrease">-</button>
                <?php echo "<input type='number' name='orderquantity[". $cart->getProductId() ."]' value='". $cart->getQuantity() ."' class='quantity-amount' min='1' max='10' readonly/>"; ?>
                <button type="button" class="increase">+</button>

                <input type="hidden" class="orderprice" value="<?= $cart->getPrice() ?>" /></br></br>
                
                <h3 class="totalamount"></h3>
            </div>
            </td>

            <td>
            <button type="button" class="btn b3" name="Delete"><a href="/FoodOrderingSystem/app/controller/AddToCartControl.php?deleteID=<?= $cart->getProductId() ?>" ><i class="fa-solid fa-trash"></i></a></button>
            </td>
<?php 
        }
} 
    ?>
        </tr>

        <button type="submit" class="btn b1" name="checkout" >Payment Checkout</button>
        <button type="submit" class="btn b2" name="clearcart" >Clear Cart</button>

    </tbody>

        <button type="button" class="btn close"><a href="menu.php" >Close</a></button></br></br>
        </form> 

    </div>
    </table>
</body>

<script>

    var sitePlusMinus = function(){
    var quantitySection = document.getElementsByClassName('quantity');

    function getCartTotal(total){

        return total;
    }

    function quantityBinding(quantitySection){
        const increaseButton = quantitySection.getElementsByClassName('increase')[0];
        const decreaseButton = quantitySection.getElementsByClassName('decrease')[0];
        const quantityAmount = quantitySection.getElementsByClassName('quantity-amount')[0];
        const priceAmount = quantitySection.getElementsByClassName('orderprice')[0];
        const totalAmount = quantitySection.getElementsByClassName('totalamount')[0];

        let firstAmount = priceAmount.value * quantityAmount.value;
        totalAmount.innerText = "Total (RM): " + firstAmount;

        increaseButton.addEventListener('click', function(){
            console.log('Button clicked');
            increaseValue(quantityAmount, priceAmount, totalAmount);
        });

        decreaseButton.addEventListener('click', function () {
            console.log('Decrease button clicked');
            decreaseValue(quantityAmount, priceAmount, totalAmount);
        });
    }

    function initiate(){
        for (var i = 0; i < quantitySection.length; i++){
            quantityBinding(quantitySection[i]);
        }
    }

    function increaseValue(quantityAmount, priceAmount, totalAmount){
        const increament = 1;
        let total = 0;
        let value = parseInt(quantityAmount.value);
        value = isNaN(value) ? 0 : value;
        value += increament;
        quantityAmount.value = value;

        console.log(priceAmount.value);
        if (value >= 0) {

            let priceValue = parseInt(priceAmount.value);

            total = priceValue * value;
            totalAmount.innerText = "Total (RM): " + total;
            console.log(totalAmount.value);
        }
    }

    function decreaseValue(quantityAmount, priceAmount, totalAmount) {
        const decrement = 1;
        let total = 0;
        let value = parseInt(quantityAmount.value);
        value = isNaN(value) ? 0 : value;
        value -= decrement;
        quantityAmount.value = value;
        console.log(quantityAmount.value);

        if (value > 0) {

            let priceValue = parseInt(priceAmount.value);

            total = priceValue * value;
            totalAmount.innerText = "Total (RM): " + total;;
            console.log(totalAmount.value);
        }



    }
    initiate();
};
sitePlusMinus();
</script>
</html>


