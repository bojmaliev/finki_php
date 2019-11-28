<?php
require_once "functions.php";
?>

<html>
<head>
    <title>Shopping list</title>
</head>
<body>
    <form action="api.php" method="post">
        Shopping list: <br />
        <input type="text" name="list_name"><br />
        Your email: <br />
        <input type="email" name="email"><br />
        Secret: <br />
        <input type="password" name="secret"><br />
        <input type="submit" value="Submit" name="create_list">
    </form>
</body>
</html>
