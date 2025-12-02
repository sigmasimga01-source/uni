<?php

require_once 'User.php';
require_once 'db.php';

$dbHelper = new Dbhelper('localhost', 'root', '', 'salesdb');
$connection = $dbHelper->getConnection();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <form action="" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="text" name="tel" placeholder="Telephone">
        <input type="password" name="pass" placeholder="Password">
        <button type="submit" name="register">Register</button>
    </form>

</body>
</html>


