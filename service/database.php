<?php

use Dom\Mysql;

$hostname = "localhost";
$username = "root";
$password = "";
$database = "php";

$db = Mysqli_connect($hostname, $username, $password, $database);

if ($db-> connect_error) {
    echo "Connection failed" ;
    die("failed");
}
?>