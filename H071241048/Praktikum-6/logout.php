<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
        <div class="text-green-500 text-4xl mb-4">✓</div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Logout Berhasil</h3>
        <p class="text-gray-600 mb-6">Anda telah berhasil logout dari sistem.</p>
        <a 
            href="index.php"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Kembali ke Login
        </a>
    </div>
</body>
</html>