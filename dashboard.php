<?php

include "service/database.php";
session_start();
if (isset($_SESSION["is_logged_in"])) {
    session_unset();
        session_destroy();
        header("Location:home.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "layout/header.html" ?>

    <h1>Selamat datang <?= $_SESSION["username"] ?></h1>
    <form action="dashboard.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <?php include "layout/footer.html" ?>
</body>

</html>