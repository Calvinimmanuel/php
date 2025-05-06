<?php
session_start();
require 'db.php';
$task = $_POST['task'];
$username = $_SESSION['username'];
$conn->query("INSERT INTO tasks (username, task) VALUES ('$username', '$task')");
header("Location: main.php");
?>
