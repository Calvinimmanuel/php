<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - My Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include "layout/header.html"; ?>
    
    <div class="container mx-auto px-4 py-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to My Website</h1>
            <p class="text-lg text-gray-600 mb-8">Discover amazing features and join our community!</p>
            <?php if (!isset($_SESSION['is_logged_in'])): ?>
                <div class="space-x-4">
                    <a href="login.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">Login</a>
                    <a href="register.php" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">Register</a>
                </div>
            <?php else: ?>
                <a href="dashboard.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>