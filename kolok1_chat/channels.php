<?php
require_once("functions.php");
if (!loggedIn())
    header("Location: index.php");
?>
<html>
<head>
    <title>Channels</title>
</head>
<body>
<table border="1">
    <thead>
    <tr>
        <th>Channel</th>
        <th>Description</th>
        <th>Messages</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $q = $pdo->prepare("SELECT * FROM `channels` ORDER BY (SELECT COUNT(*) FROM `messages` WHERE `channels`.id = `messages`.channel AND `is_read`=0)");
    $q->execute();
    while ($row = $q->fetch()) {
        ?>
        <tr>
            <td><a href="channel.php?channel-id=<?=$row["id"]?>"><?= $row["name"] ?></a></td>
            <td><?= $row["description"] ?></td>
            <td>

                <?php
                $mes = $pdo->prepare("SELECT `message_text` FROM `messages` WHERE `channel`=:ch AND `is_read`=0");
                $mes->bindParam(":ch", $row["id"]);
                $mes->execute();
                while ($msg = $mes->fetch()) {
                    ?>
                    <?= $msg["message_text"]; ?><br/>
                    <?php
                }
                ?>

            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
</body>
</html>
