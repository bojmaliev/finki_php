<?php
require_once("functions.php");
if (!empty($_GET["add_to_fav"])) {

    setFavorite($_GET["add_to_fav"]);

    header("Location: $_SERVER[HTTP_REFERER]");
}
if(isset($_POST["login_for_list"])){
    $listId = $_POST["listId"];
    $password = md5($_POST["password"]);

    $query = $pdo->prepare("SELECT * FROM `shopping_list` WHERE `id` = :listId AND `secret` = :secret");
    $query->bindParam(":listId", $listId);
    $query->bindParam(":secret", $password);
    $query->execute();

    if($query->rowCount() == 1){
        authUserForId($listId);
        setFavorite($listId);
    }
        header("Location: $_SERVER[HTTP_REFERER]");
}
if(isset($_GET["product_id"]) && isset($_GET["q"])){
    $product = $pdo->prepare("SELECT * FROM `products` WHERE `id` = :productId");
    $product->bindParam(":productId", $_GET["product_id"]);
    $product->execute();
    $product = $product->fetch();
    if(isAuthForList($product["shopping_list_id"])){
        $quantity = $product["quantity"]+$_GET["q"];
        $is_bought = $quantity==0 ? 1 : 0;
        $is_urgent = $product["is_urgent"];
        if($is_bought)$is_urgent=0;
        $q = $pdo->prepare("UPDATE `products` SET `quantity`=:q, `is_bought`=:b, `is_urgent`=:u WHERE `id`=:pId");
        $q->bindParam("q", $quantity);
        $q->bindParam("b", $is_bought);
        $q->bindParam("u", $is_urgent);
        $q->bindParam("pId", $_GET["product_id"]);
        $q->execute();
    }
    header("Location: $_SERVER[HTTP_REFERER]");
}
if(isset($_POST["create_list"])){
    if(!empty($_POST["list_name"]) && !empty($_POST["secret"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $q = $pdo->prepare("SELECT * FROM `shopping_list` WHERE `creator`=:c AND `list_name`=:n");
        $q->bindParam(":c", $_POST["email"]);
        $q->bindParam(":n", $_POST["list_name"]);
        $q->execute();
        if($q->rowCount() == 0){
            $secret = md5($_POST["secret"]);
            $insert = $pdo->prepare("INSERT INTO `shopping_list` (`list_name`, `creator`, `secret`) VALUES (:namme,:creator, :secret)");
            $insert->bindParam(":namme", $_POST["list_name"]);
            $insert->bindParam(":creator", $_POST["email"]);
            $insert->bindParam(":secret", $secret);
            $insert->execute();
        }
    }
    header("Location: $_SERVER[HTTP_REFERER]");


}
if(isset($_POST["add_product"])){
    if(!empty($_POST["list_name"]) || !empty($_POST["quantity"])){
        $q = $pdo->prepare("INSERT INTO `products` (`product_name`, `shopping_list_id`, `quantity`, `is_bought`, `is_urgent`, `created_at`) VALUE (:product_name, :shopping_list_id, :quantity, 0, :is_urgent, NOW())");
        $q->bindParam(":product_name", $_POST["list_name"]);
        $q->bindParam(":shopping_list_id", $_POST["shopping_list"]);
        $q->bindParam(":quantity", $_POST["quantity"]);
        $urgent = !empty($_POST["urgent"]) ? 1: 0;
        $q->bindParam(":is_urgent", $urgent);
        $q->execute();
    }
    //header("Location: $_SERVER[HTTP_REFERER]");

}