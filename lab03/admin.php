<?php
include "database.php";
require "functions.php";
?>

<html>
<head>
    <title>News Admin panel</title>
</head>

<?php
if (isset($_GET["page"])) {
    switch ($_GET["page"]) {
        case "edit":
            $query = $pdo->prepare("SELECT * FROM `news` WHERE `news_id`=:id");
            $query->bindParam(":id", $_GET["id"]);
            $query->execute();
            $row = $query->fetch();

            ?>
            <form action="admin.php" method="post">
                Title:<br/>
                <input type="text" name="title" value="<?= $row["news_title"] ?>"/><br/>
                Text:<br/>
                <textarea name="full_text"><?= $row["full_text"] ?></textarea><br/>
                <input type="hidden" name="news_id" value="<?= $row["news_id"] ?>"/>
                <input type="submit" name="patch_news"/>
            </form>
            <?php
            break;
        case "new_article":
            ?>
            <form action="admin.php" method="post">
                Title:<br/>
                <input type="text" name="title"/><br/>
                Text:<br/>
                <textarea name="full_text"></textarea><br/>
                <input type="submit" name="post_news"/>

            </form>
            <?php
            break;
        case "review_comments":
            $comment_query = $pdo->prepare("SELECT * FROM `comments` WHERE `news_id`=:post_id");
            $comment_query->bindParam(":post_id", $_GET["id"]);
            $comment_query->execute();
            ?>
            <a href="admin.php">Return to news</a>
            <?php
            if($comment_query->rowCount()==0)echo "<br />No comments found";
            while ($row = $comment_query->fetch()) {
                ?>
                <p style="border: 1px solid black;">
                    <b><?= $row["author"] ?> wrote:</b>
                    <?= $row["comment"] ?><br/>
                    <?=($row["approved"] == 0? "<a href=\"admin.php?approve_comment=$row[comment_id]\">Approve</a>" : "")?>
                    <a href="admin.php?delete_comment=<?=$row["comment_id"]?>">Delete</a>
                </p>
                <?php
            }
            break;
    }
} else {
    if (isset($_GET["delete"])) {
        $q = $pdo->prepare("DELETE FROM `news` WHERE `news_id`=:news_id");
        $q->bindParam("news_id", $_GET["delete"]);
        $q->execute();
    }else if (isset($_GET["approve_comment"])) {
        $q = $pdo->prepare("UPDATE `comments` SET `approved` = 1  WHERE `comment_id`=:comment_id");
        $q->bindParam("comment_id", $_GET["approve_comment"]);
        $q->execute();
    }else if (isset($_GET["delete_comment"])) {
        $q = $pdo->prepare("DELETE FROM `comments` WHERE `comment_id`=:comment_id");
        $q->bindParam("comment_id", $_GET["delete_comment"]);
        $q->execute();
    }

    if (isset($_POST)) {
        if (isset($_POST["post_news"])) {
            $q = $pdo->prepare("INSERT INTO `news` (`date`, `news_title`, `full_text`) VALUES(now(), :title, :text)");
            $q->bindParam(":title", $_POST["title"]);
            $q->bindParam(":text", $_POST["full_text"]);
            $q->execute();
        } else if (isset($_POST["patch_news"])) {
            $q = $pdo->prepare("UPDATE `news`  SET `news_title` =:title, full_text=:full_text WHERE `news_id`=:news_id");
            $q->bindParam(":title", $_POST["title"]);
            $q->bindParam(":full_text", $_POST["full_text"]);
            $q->bindParam(":news_id", $_POST["news_id"]);
            $q->execute();
        }
    }
    ?>
    <a href="admin.php?page=new_article">Write new article</a>
    <table border="1">
        <thead>
        <th>News id</th>
        <th>News date</th>
        <th>News title</th>
        <th>News Article</th>
        <th>Edit comments</th>
        <th>Edit</th>
        <th>Delete</th>
        </thead>
        <tbody>
        <?php
        $q = $pdo->prepare("SELECT * FROM `news` ORDER BY `date` DESC ");
        $q->execute();
        while ($row = $q->fetch()) {
            $num_comments = $pdo->query("SELECT * FROM `comments` WHERE `news_id`=$row[news_id] AND approved=0")->rowCount();
            ?>
            <tr>
                <td><?= $row["news_id"] ?></td>
                <td><?= $row["date"] ?></td>
                <td><?= $row["news_title"] ?></td>
                <td><?= first_100_words($row["full_text"]) ?></td>
                <td><a href="admin.php?page=review_comments&id=<?= $row["news_id"] ?>">New comments(<?= $num_comments ?>
                        )</a>
                </td>
                <td><a href="admin.php?page=edit&id=<?= $row["news_id"] ?>">Edit</a></td>
                <td><a href="admin.php?delete=<?= $row["news_id"] ?>">Delete</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>
</body>
</html>
