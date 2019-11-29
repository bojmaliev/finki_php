<?php
require_once("functions.php");
if (loggedIn())
    header("Location: channels.php");
?>

<html>
<head>
    <title>Naslov</title>
</head>
<body>

<form action="functions.php" method="post">
    Username:<br/>
    <input type="text" name="username" value="<?= !empty($_COOKIE["username"]) ? $_COOKIE["username"]:"" ?>"><br/>
    Email:<br/>
    <input type="email" name="email" value="<?= !empty($_COOKIE["email"])?  $_COOKIE["email"]:"" ?>"><br/>
    <input type="submit" name="login" value="Login">
</form>

</body>
</html>
