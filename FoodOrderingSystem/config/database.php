<?php

$host = 'localhost';
$dbName = 'foodorderingsystem';
$dbuser = 'root';
$dppassword = '';


function getConnection(){
    
         // set up DSN
        $dsn = "mysql:host=$host;dbname=$dbName";

         try {
            $db = new PDO($dsn, $dbuser, $dbpassword);
            echo "<p>Connection to database successful</p>";
        } catch (PDOException $ex) {
            echo "<p>Connection Failed " .$ex->getMessage() . "</p>";
            exit;
        }
}
