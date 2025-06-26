<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Alam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-glass p-10 rounded-xl shadow-xl w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-green-800 mb-2">Selamat Datang 🌿</h1>
            <p class="text-gray-700">Silakan login untuk menjelajahi keindahan alam</p>
        </div>

        <?php if (!empty($login_message)): ?>
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
                    class="w-full px-4 py-3 pl-10 border border-green-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none" 
                    required
                >
                <svg class="w-5 h-5 absolute left-3 top-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>

            <div class="relative">
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    class="w-full px-4 py-3 pl-10 border border-green-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none" 
                    required
                >
                <svg class="w-5 h-5 absolute left-3 top-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 17a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                    <path d="M4 7h16v4H4z" />
                    <path d="M6 7V5a6 6 0 0 1 12 0v2" />
                </svg>
            </div>

            <button 
                type="submit" 
                name="login" 
                class="w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700 transition duration-200 font-semibold"
            >
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-700">
            Belum punya akun? <a href="register.php" class="text-green-700 hover:underline">Daftar di sini</a>
        </p>
    </div>
</html>
