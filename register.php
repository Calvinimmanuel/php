<?php
include "service/database.php";

$register_message = "";

if (isset($_POST['register'])) {
    echo " Terimakasih sudah mendaftar";
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simpan ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($db->query($query)) {

        $register_message = "daftar berhasil, silahkan masuk";
    } else {
    $register_message = "daftar gagal, silahkan coba lagi";
    }
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
    <i><?= $register_message?></i>
    <h3> DAFTAR AKUN</h3>
    <form action="register.php" method="POST">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <button type="submit" name="register"> daftar sekrang</button>
    </form>
    <main>
        <p>Halo Selamat datang di website saya</p>
    </main>
    <?php include "layout/footer.html" ?>
</body>

</html>