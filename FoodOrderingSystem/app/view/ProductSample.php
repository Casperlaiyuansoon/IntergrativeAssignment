<!DOCTYPE html>

<?php 

require_once "C:/xampp/htdocs/FoodOrderingSystem/app/models/Product.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/CartItemFactory.php";
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/controller/DBConfig.php";
//require_once "C:/xampp/htdocs/AssignmentFOS/MVC/Controller/CartSystem.php";

session_start();

//Sample Email
$_SESSION['email'] = "zy@gmail.com";

$product = new Product($id = "", $product = "", $image = "", $price = "", $description = "");

$sql = "SELECT ID, PRODUCTNAME, IMAGE, PRICE, DESCRIPTION FROM PRODUCT";
$result = $db->query($sql);
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $ProductArr[] = new Product($row['ID'], $row['PRODUCTNAME'], $row['IMAGE'], $row['PRICE'], $row['DESCRIPTION']);
}

if((isset($_POST['AddToCart']))){

    $productID = $_POST['ProductID'];
    $price = $_POST['ProductPrice'];
    $quantity = 1;

    $cart = CartItemFactory::createCart($product->productInsert($productID, $price, $quantity), "Insert");
}

function insertItem(Product $product){

    require "C:/xampp/htdocs/FoodOrderingSystem/app/controller/DBConfig.php";
    
    $getEmail = $_SESSION['email'];

    $sql1 = "SELECT CARTID, USEREMAIL FROM CART WHERE USEREMAIL = '$getEmail'";
    $result1 = $db->query($sql1);
    $result1->execute();

    $dataRow = $result1->rowCount();

    if($dataRow == 0){

        $sql2 = "INSERT INTO CART(USEREMAIL) VALUES (?)";
        $result2 = $db->prepare($sql2);
        $result2->bindParam(1, $getEmail);

        $result2->execute();

        $sql1 = "SELECT CARTID, USEREMAIL FROM CART WHERE USEREMAIL = '$getEmail'";
        $result1 = $db->query($sql1);
        $result1->execute();

        while($row = $result1->fetch(PDO::FETCH_ASSOC)){

            $cartID = $row['CARTID'];
            $sql1 = "INSERT INTO CARTITEM(CARTID, PRODUCTID, CARTPRICE, CARTQUANTITY) VALUES (?, ?, ?, ?)";
            $statement = $db->prepare($sql1);
            $statement->bindParam(1, $cartID);
            $statement->bindParam(2, $product->getId());
            $statement->bindParam(3, $product->getPrice());
            $statement->bindParam(4, $product->getQuantity()); 
    
            $statement->execute();
            
        }
        header("location: /FoodOrderingSystem/Public/AddToCartView.php");

    }

    else{
        while($row = $result1->fetch(PDO::FETCH_ASSOC)){

            $cartID = $row['CARTID'];
            $sql1 = "INSERT INTO CARTITEM(CARTID, PRODUCTID, CARTPRICE, CARTQUANTITY) VALUES (?, ?, ?, ?)";
            $statement = $db->prepare($sql1);
            $statement->bindParam(1, $cartID);
            $statement->bindParam(2, $product->getId());
            $statement->bindParam(3, $product->getPrice());
            $statement->bindParam(4, $product->getQuantity()); 
    
            $statement->execute();
        }
    }
    header("location: /FoodOrderingSystem/Public/AddToCartView.php");
}
?>

<style>
body{
    width: 100%;
    position: absolute;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.description{
    padding: 50px;
    margin: auto;
    height: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: center;
    padding: 8px;
    border-bottom: 2px solid #ddd;
}

button.btn{
    width: 200px;
    height: 50px;
    margin: auto;
    padding: 10px;
    border: none;
    box-shadow: 2px 2px  rgba(0, 0, 0, 0.3);
}

.btn.b1{
    background-color: aqua;
}

.btn.b2{
    background-color: #FFBB40;
}

footer {
    width: 99%;
    height: 100px;
    background-color: #FFBB40;
    color: #fff;
    padding: 10px;
    text-align: center;
    margin-top: 20px;
    position: relative;
}
</style>
<html>

<head>
<title>Product</title>
</head>

<body>
    <div class="description">
            <h3>Table Design</h3>

            <h3><?= $_SESSION['email'] ?></h3>

            <div class="row">
            <table style="width: 100%;">

        <tbody>

        <?php 
        foreach($ProductArr as $product){
            
            $image = $product->getImage();
        ?>
        <tr>
            <td>
                <img src="<?= $image ?>" alt="" style="width:50%; display:block;" >
            </td>

            <td>
                <h3><?= $product->getProductName() ?></h3>
            </td>
            <td>
                <h3><?= $product->getPrice() ?></h3>
            </td>

            <td>
                <h3><?= $product->getDescription() ?></h3>
            </td>

            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >

                <input type="hidden" value="<?= $product->getId() ?>" name="ProductID" />
                <input type="hidden" value="<?= $product->getPrice() ?>" name="ProductPrice" />


                <td>
                    <button type="submit" class="btn b1" name="AddToCart" >Add To Cart</button>
                    <button type="button" class="btn b2">View Product</button>
                </td>

            </form>
        </tr>

        <?php } ?>

        </tbody>
    </table>
        </div>

    </div>

</body>


</html>