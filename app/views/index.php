<?php

require_once '../controllers/AuthController.php';

$controller = new AuthController();
$controller->register();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styless.css">
</head>

<body>

    <?php if (!empty($controller->message)) echo "<p>" . htmlspecialchars($controller->message) . "</p>" ?>

    <nav>
        <a href="index.php">Register</a>
        <a href="login.php">Login</a>
    </nav>

    <form action="" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="tel" placeholder="Telephone">
        <input type="password" name="password" placeholder="password">
        <button type="submit" name="register">Register</button>
    </form>

</body>

</html>