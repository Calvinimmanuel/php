<?php 
if (isset($_POST['login'])){
    echo " terimkasih sudah login ";
    $username= $_POST['username'];
    $password = $_POST['password'];
    
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
    <h3>MASUK AKUN</h3>
    <form action="login.php" method="post">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <button type="submit" name="login"> masuk sekrang</button>
    </form>
    <main>
        <p>Halo Selamat datang di website saya</p>
    </main>
    <?php include "layout/footer.html" ?>
</body>

</html>