<?php
session_start();
require 'db.php';
$id = $_GET['id'];
$conn->query("UPDATE tasks SET done = 1 WHERE id = $id");
header("Location: main.php");
?>
