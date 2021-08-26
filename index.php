<?php
include "inc/autoloader.inc.php";
// require "./app/Dbh.class.php";
// require "./app/module/users.class.php";
// require "./app/controller/userControl.class.php";
$userControl = new UserControl();
$userControl->isLoggedIn();


var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>test php 19-08-2021</h1>
    <a href="logout.php">logout</a>
</body>
</html>
