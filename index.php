<?php

session_start();

if(isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/DB.php";

    $sql = "SELECT * FROM user
    WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Home</title>
</head>
<body>
    <h1>Home</h1>
    <?php if (isset($user)): ?>
        <p>Hello <?php htmlspecialchars($user["name"]) ?></p>
        <p>You are logged in</p>
        <p><a href="logout.php">Log Out</a></p>
    <?php else: ?>
        <p><a href="Login.php">Log In</a> Or <a href="signup.html">sign up</a></p>
    <?php endif; ?>
    </body>
    </html>