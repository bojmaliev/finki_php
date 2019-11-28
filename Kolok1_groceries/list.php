<?php
require_once "functions.php";
if (empty($_GET['id'])) header("Location: index.php");
?>
<html>
<head>
    <title>Shopping list</title>
</head>
<style type="text/css">
    table tr td {
        border-bottom: 1px solid black;
    }
</style>
<?php
if (!isAuthForList($_GET['id'])) {
    ?>
    <form action="api.php" method="post">
        Enter password:<br/>
        <input type="password" name="password"><br/>
        <input type="hidden" name="listId" value="<?= $_GET["id"] ?>">
        <input type="submit" name="login_for_list">
    </form>
    <?php
} else {
    $products = $pdo->prepare("SELECT * FROM `products` WHERE `shopping_list_id` = :listId ORDER BY `is_urgent` DESC, `is_bought` ASC");
    $products->bindParam(":listId", $_GET["id"]);
    $products->execute();
    ?>
    <table>
        <thead>
        <th>Name</th>
        <th>Quantity</th>
        <th>Add</th>
        <th>Minus</th>
        </thead>
        <tbody>
        <?php
        while ($row = $products->fetch()) {
            ?>
            <tr <?= $row["is_urgent"] ? "style='font-weight:bold'" : "" ?>>
                <td <?= $row["is_bought"] ? "style='text-decoration: line-through'" : "" ?>>
                    <a href="<?= $row["is_bought"] ? "api.php?product_id=$row[id]&q=+1" : "api.php?product_id=$row[id]&q=-$row[quantity]" ?>">
                        <?= $row["product_name"] ?>
                    </a>
                </td>
                <td>
                    <?= $row["is_bought"] ? "" : $row["quantity"] ?>
                </td>
                <td>
                    <a href="api.php?product_id=<?= $row['id'] ?>&q=+1">+1</a>
                </td>
                <td>
                    <a href="api.php?product_id=<?= $row['id'] ?>&q=-1">-1</a>
                </td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
    <form action="api.php" method="post">
        Name:<br>
        <input type="text" name="list_name"><br>
        Quantity:<br>
        <input type="number" name="quantity"><br>
        Is urgent:
        <input type="checkbox" name="urgent"><br>
        <input type="hidden" name="shopping_list" value="<?= $_GET["id"] ?>">
        <input type="submit" name="add_product" value="Add to list">
    </form>
    <?php
}
?>
</body>
</html>