<?php
include "database.php";
if(!isset($_GET["id"]))header("Location: index.php");
?>
<html>
<head>
    <title>News</title>
</head>
<body>
<?php
    $postId = $_GET["id"];
    $msg=null;
    if (isset($_POST["submit_comment"]) && isset($_POST["author"]) && isset($_POST["comment"]) && !empty($_POST["author"]) && !empty($_POST["comment"])) {

        $query = $pdo->prepare("INSERT INTO `comments` (`news_id`, `author`, `comment`, `approved`) VALUES (:post_id, :author, :comment, 0)");
        $query->bindParam(":post_id", $postId, PDO::PARAM_INT);
        $query->bindParam(":author", $_POST["author"]);
        $query->bindParam(":comment", $_POST["comment"]);
        $query->execute();
        $msg="Your comment was successfully posted and waiting for approval";
    }
    $query = $pdo->prepare("SELECT * FROM `news` WHERE `news_id`=:id");
    $query->bindParam(":id", $postId, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch();
    ?>
    <h1><?= $row["news_title"] ?></h1>
    <span>Published on: <?= $row["date"] ?></span>
    <p><?= $row["full_text"] ?></p>
    <hr/>
    <b>Comment list:</b><br/>
    <?php
    $comment_query = $pdo->prepare("SELECT * FROM `comments` WHERE `news_id`=:post_id AND `approved`=1 ");
    $comment_query->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $comment_query->execute();
    while ($row = $comment_query->fetch()) {
        ?>
        <p><b><?= $row["author"] ?> wrote:</b> <?= $row["comment"] ?> </p>
        <?php
    }

    ?>
    <hr/>
    <b><?=$msg?></b>
    <form action="post.php?id=<?=$postId?>" method="post">
        Author: <br/><input name="author" type="text"/><br/>
        Comment: <br/><input name="comment" type="text"/><br/>
        <input type="submit" name="submit_comment" value="Submit comment"/>

    </form>
</body>
</html>
