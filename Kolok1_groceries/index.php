<?php
require_once("functions.php");
?>

<html>
<head>
    <title>Shopping list</title>
</head>
<body>
<?php
$shoppingList = null;
if (empty($_COOKIE["favorites"]) || !empty($_GET["view_all"])) {
    $shoppingList = $pdo->prepare("SELECT * FROM `shopping_list`");
    $shoppingList->execute();

} else {
    $favs = getFavorites();
    $arr = array();
    foreach ($favs as $value) {
        $arr[] = "?";
    }
    $string = implode(", ", $arr);
    $shoppingList = $pdo->prepare("SELECT * FROM `shopping_list` WHERE `id`  in ($string)");
    $shoppingList->execute($favs);
    ?>
    <a href='index.php?view_all=1'>See all</a>

    <?php
}

?>
&nbsp; <a href='add_shopping_list.php'>Add shopping list</a>
<ul>
    <?php
    while ($row = $shoppingList->fetch()) {
        ?>
        <li>
            <a href="list.php?id=<?= $row["id"]; ?>"><?= $row["list_name"]; ?></a>
            <?php
            if (!isIdInFavorites($row["id"])) {
                ?>
                - <a href="api.php?add_to_fav=<?= $row["id"]; ?>">Add to fav</a>
                <?php
            }
            ?>

        </li>
        <?php
    }
    ?>
</ul>

</body>
</html>
