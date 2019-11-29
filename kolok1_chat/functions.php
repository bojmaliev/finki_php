<?php
require_once("database.php");

function loggedIn()
{
    return isset($_COOKIE["last_logged"]) ;
}

if (isset($_POST["login"])) {
    if (!empty($_POST["username"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        setcookie("last_logged", 1, time() + 3600 * 2);
        setcookie("username", $_POST["username"], time() + 3600 * 24 * 7);
        setcookie("email", $_POST["email"], time() + 3600 * 24 * 7);

        header("Location: channels.php");
    }
    header("index.php");
}
if(isset($_POST["new_message"])){
    if(!empty($_POST["message"])){
        $query = $pdo->prepare("INSERT INTO `messages` 
(`message_text`, `sender_username`, `sender_email`, `channel`, `time_sent`, `is_read`) VALUES 
(:msg, :username, :email, :channel, now(), 0) ");
        $query->bindParam("msg", $_POST["message"]);
        $query->bindParam("username", $_COOKIE["username"]);
        $query->bindParam("email", $_COOKIE["email"]);
        $query->bindParam("channel", $_POST["channel"]);
        $query->execute();
    }
    header("Location: $_SERVER[HTTP_REFERER]");
}