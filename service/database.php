<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "php";

try {
    $db = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }

    // Set character set to utf8mb4
    if (!$db->set_charset("utf8mb4")) {
        throw new Exception("Error loading character set utf8mb4: " . $db->error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
