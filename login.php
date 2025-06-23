<?php
include "service/database.php";
session_start();

$login_message = "";

if (isset($_SESSION["is_logged_in"])) {
    header("Location: home.php");
}

if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if $db is defined
    if (!isset($db)) {
        $login_message = "Error: Database connection failed.";
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            // Verify password (assuming passwords are hashed in the database)
            if (password_verify($password, $data['password'])) {
                $_SESSION["username"] = $data["username"];
                $_SESSION["is_logged_in"] = true;
                header("Location: home.php");
                exit;
            } else {
                $login_message = "Username atau password salah";
            }
        } else {
            $login_message = "Username atau password salah";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <?php include "layout/header.html" ?>
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">Masuk Akun</h3>
        <?php if ($login_message): ?>
            <p class="text-red-500 text-center mb-4"><?php echo $login_message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post" class="space-y-4">
            <div>
                <input 
                    type="text" 
                    placeholder="Username" 
                    name="username" 
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            <div>
                <input 
                    type="password" 
                    placeholder="Password" 
                    name="password" 
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            <button 
                type="submit" 
                name="login" 
                class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-200"
            >
                Masuk Sekarang
            </button>
        </form>
        <main class="mt-6 text-center">
            <p class="text-gray-600">Halo, Selamat datang di website saya!</p>
        </main>
        <?php include "layout/footer.html" ?>
    </div>
</body>
</html>