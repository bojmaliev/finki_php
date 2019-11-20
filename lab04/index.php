<?php
session_start();
include_once "classes/FileUpload.php";
include_once "classes/ContactParser.php";
include_once "classes/Logger.php";

$logger = new Logger("log.txt");
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/19/2019
 * Time: 12:49 AM
 */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>WebSite</title>
</head>
<body>
<?php
if (isset($_SESSION["file"]) && isset($_GET["cmd"])) {
    if ($_GET["cmd"] == "delete") {
        unlink($_SESSION["file"]);
        unset($_SESSION["file"]);
    }
}
if (isset($_POST["uploadFile"])) {
    $uploader = new FileUpload("uploads/", $_FILES["file"]);
    try {
        $name = $uploader->checkSize(3000)->checkFormat(["txt"])->upload();
        $_SESSION["file"] = $name;
    } catch (Exception $e) {
        $logger->write($e->getMessage());
        echo $e->getMessage();
    }
}
if (!isset($_SESSION["file"])) {
    ?>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file"/>
        <input type="submit" name="uploadFile" value="upload file">
    </form>
    <?php
} else {
    ?>
    You have uploaded <?= $_SESSION["file"] ?><br/>
    <a href="index.php?cmd=show">Show it</a> <a href="index.php?cmd=check_errors">Check errors</a> <a
            href="index.php?cmd=delete">Delete it</a>
    <?php
    if (isset($_GET["cmd"])) {
        if ($_GET["cmd"] == "show") {
            $parser = new ContactParser($_SESSION["file"]);
            ?>
            <table>
                <thead>
                <th>Name:</th>
                <th>Phone:</th>
                <th>Email:</th>
                <th>Address:</th>
                </thead>
                <tbody>
                <?php
                foreach ($parser->getRows() as $row) {
                    ?>
                    <tr>
                        <td><?= $row[0] ?></td>
                        <td><?= $row[1] ?></td>
                        <td><?= $row[2] ?></td>
                        <td><?= $row[3] ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php

        } else if ($_GET["cmd"] == "check_errors") {
            $parser = new ContactParser($_SESSION["file"]);
            try {
                echo $parser->check_errors();
            } catch (Exception $e) {
                $logger->write($e->getMessage());
                echo $e->getMessage();
            }

        }
    }
}
?>
</body>
</html>
