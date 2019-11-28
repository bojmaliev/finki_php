<?php
if(!empty($_POST)){
    $text = $_POST["processTxt"];
    $niza = explode('$', $text);
    $num=0;
    foreach ($niza as $item) {
        $num+=$item;
    }
    echo $num;
}
?>

<form action="zadaca1.php" method="post">
    Enter text:
    <input name="processTxt" type="text"/>
    <br/>
    <input type="submit" value="Value">
</form>