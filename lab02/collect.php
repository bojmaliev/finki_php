<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/9/2019
 * Time: 12:53 AM
 */
session_start();


if ($_GET) {

    if (isset($_GET['ime']) && $_GET['ime'] != "" &&
        isset($_GET['prezime']) && $_GET['prezime'] != "" &&
        isset($_GET['email']) && $_GET['email'] != "") {
        if (isset($_GET["zapamtiMe"]) && $_GET["zapamtiMe"] == "on") {
            $name = $_GET["ime"] . " " . $_GET["prezime"];
            setcookie("name", $name, time() + 7200, "/"); // 86400
            $_SESSION["name"] = $name;
            $_SESSION["time"] = date("Y-m-d H:i:s");
        }
        foreach ($_GET as $key => $item) {
            print "'$key' = $item<br/>";
        }


    } else echo "Ne e validno";

}
if (isset($_COOKIE['name'])) {
    echo "Hello, " . $_COOKIE['name'] . "<br />";
}
if(isset($_SESSION["name"]) && isset($_SESSION["time"])){
    if(strtotime($_SESSION["time"])+7200 > strtotime(date("Y-m-d H:i:s"))){
        echo "Hello, " . $_SESSION['name'] . ", you are still logged in<br />";
    }
}