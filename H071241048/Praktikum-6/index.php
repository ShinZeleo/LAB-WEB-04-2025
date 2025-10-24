<?php
session_start();
include "db.php";

if (isset($_SESSION['user'])) {
  header("Location: dashboard.php");
  exit;
}

$login_error_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input_username = trim($_POST['username'] ?? "");
  $input_password = trim($_POST['password'] ?? "");

  if ($input_username === "" || $input_password === "") {
    $login_error_message = "Username dan password wajib diisi.";
  } else {
    $password_hash = md5($input_password); 
    $select_user_sql  = "SELECT id, username, role, project_manager_id 
                         FROM users 
                         WHERE username = ? AND password = ?
                         LIMIT 1";
    if ($user_query_stmt = $conn->prepare($select_user_sql)) {
      $user_query_stmt->bind_param("ss", $input_username, $password_hash);
      $user_query_stmt->execute();
      $user_result = $user_query_stmt->get_result();
      if ($user_result && $user_result->num_rows === 1) {
        $authenticated_user_data = $user_result->fetch_assoc();
        $_SESSION['user'] = [
          'id' => (int)$authenticated_user_data['id'],
          'username' => $authenticated_user_data['username'],
          'role' => $authenticated_user_data['role'],
          'project_manager_id' => $authenticated_user_data['project_manager_id'] !== null ? (int)$authenticated_user_data['project_manager_id'] : null
        ];
        header("Location: dashboard.php");
        exit;
      } else {
        $login_error_message = "Login gagal. Periksa username dan password.";
      }
      $user_query_stmt->close();
    } else {
      $login_error_message = "Kesalahan server.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
        
        <?php if($login_error_message): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($login_error_message) ?>
        </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-4">
                <input 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    type="text" 
                    name="username" 
                    placeholder="Username" 
                    required
                >
            </div>
            <div class="mb-6">
                <input 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    required
                >
            </div>
            <button 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                type="submit"
            >
                Masuk
            </button>
        </form>
    </div>
</body>
</html>