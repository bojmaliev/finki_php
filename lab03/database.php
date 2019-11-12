<?php
include_once "db.php";
$pdo = null;
try{
    $pdo = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_DATABASE; charset=$MYSQL_CHARSET", $MYSQL_USER, $MYSQL_PASS, $MYSQL_OPTIONS);


}
catch (PDOException $pe){
    die("Could not connect: ". $pe->getMessage());
}catch (Exception $e){
    die("Could not connect: ". $pe->getMessage());
}