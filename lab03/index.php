<?php
include "database.php";
require "functions.php"
?>

<html>
<head>
    <title>News</title>
</head>
<body>
<?php
$q = $pdo->prepare("SELECT * FROM `news` ORDER BY `date` DESC LIMIT 5");
$q->execute();
while ($row = $q->fetch()) {
    ?>
    <div style="border-bottom:1px solid black;">
        <h3><a href="post.php?id=<?=$row["news_id"]?>"><?=$row["news_title"]?></a></h3>
        <p><?=first_100_words($row["full_text"])?></p>
    </div>
    <?php
}

?>
</body>
</html>
