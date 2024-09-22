<?php 
require_once "C:/xampp/htdocs/FoodOrderingSystem/app/model/Cart.php";

//Sample Database Connectionn by Tee Zhen Yu
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "test1";

$dsn = "mysql:host=$dbHost;dbname=$dbName";

try{
    $db = new PDO($dsn, $dbUser, $dbPassword);
    //echo "Database Connected";
}

catch(Exception $ex){
    echo "<p>Error: ". $ex->getMessage() ."</p>";
    exit;
}