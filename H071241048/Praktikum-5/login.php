<?php
    session_start();
    if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
    }
    $error = $_SESSION['error'] ?? '';
    unset($_SESSION['error']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        form {
            margin-bottom: 8px; 
        }
    </style>
</head>
<body>
    <div class="card shadow-sm" style="width: 22rem; height: auto;">
        <div class="card-body p-4">
            <h1 class="card-title text-center mb-4">Silahkan Login!</h1>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>   
        <form action="proses_login.php" method="post">
                <label class="form-label" for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required><br><br>
                <label class="form-label" for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required><br><br>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

