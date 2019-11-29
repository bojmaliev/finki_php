<?php
require_once("functions.php");
if (!loggedIn())
    header("Location: index.php");
if (!isset($_GET["channel-id"]))
    header("Location: channels.php");
?>
<html>
<head>
    <title>Channels</title>
</head>
<style type="text/css">

    div{
        border-bottom:1px solid black;
    }
</style>
<body>
<?php
$msgs = $pdo->prepare("SELECT * FROM `messages` WHERE `channel`=:ch ORDER BY `time_sent`");
$msgs->bindParam(":ch", $_GET["channel-id"]);
$msgs->execute();
while ($row = $msgs->fetch()) {
    ?>
    <div>
        <i><?=$row["time_sent"]?></i> <b><?=$row["sender_username"]?></b> : <?=$row["message_text"]?> <span><?=$row["is_read"]==1 ? "| seen" :""?></span>
    </div>
    <?php
    $update = $pdo->prepare("UPDATE `messages` SET `is_read`=1 WHERE `is_read`=0 AND `id`=:msgId AND `sender_email` != :email");
    $update->bindParam("msgId", $row["id"]);
    $update->bindParam("email", $_COOKIE["email"]);
    $update->execute();

}
?>
<form action="functions.php" method="post">
    <textarea name="message" maxlength="200"></textarea>
    <input type="hidden" name="channel" value="<?=$_GET["channel-id"]?>"/>
    <input type="submit" name="new_message" value="Post message">
</form>
</body>
</html>