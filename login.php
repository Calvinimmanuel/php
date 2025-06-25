<?php
include "service/database.php";
session_start();

$login_message = "";

if (isset($_SESSION["is_logged_in"])) {
    header("Location: home.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!isset($db)) {
        $login_message = "Error: Database connection failed.";
    } else {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 to-indigo-200 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md space-y-6">
        <?php include "layout/header.html" ?>

        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        <?php if ($login_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm text-center">
                <?php echo $login_message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post" class="space-y-5">
            <div class="relative">
                <input 
                    type="text" 
                    name="username" 
                    placeholder="Username" 
                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    required
                >
                <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>

            <div class="relative">
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    required
                >
                <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 17a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                    <path d="M4 7h16v4H4z" />
                    <path d="M6 7V5a6 6 0 0 1 12 0v2" />
                </svg>
            </div>

            <button 
                type="submit" 
                name="login" 
                class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition duration-200 font-semibold"
            >
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>

        <?php include "layout/footer.html" ?>
    </div>
</body>
</html>
