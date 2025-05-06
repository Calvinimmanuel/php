<?php
session_start();
require 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM tasks WHERE id = $id");
header("Location: main.php");
?>
