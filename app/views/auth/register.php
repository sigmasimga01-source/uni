<?php

require_once '../app.php';

$authController->register();

?>

<!DOCTYPE html>
<html lang="en">

<?php 
$name = "Register";
include 'partials/header.php'; 
?>

<body>

    <?php if (!empty($authController->message)) echo "<p>" . htmlspecialchars($authController->message) . "</p>" ?>

    <?php include 'partials/navbar.php'; ?>

    <main>
        <?php if (!empty($authController->message)): ?>
            <div class="message <?= strpos($authController->message, 'Success') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($authController->message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <h1>Register</h1>
            <input type="text" name="name" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="tel" name="tel" placeholder="Phone Number">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Create Account</button>
        </form>
    </main>

</body>

</html>