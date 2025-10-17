<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
    $user = $_SESSION['user'];
    include 'data.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container text-left bg-white p-5 rounded shadow" style="max-width: 800px;">
        <?php if ($user['username'] === 'adminxxx'): ?>
            <h1 class="display-4">Selamat datang, Admin!</h1>
            <p class="lead">Ini adalah halaman dashboard untuk admin.</p>
            <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
            
            <h3 class="mt-5 mb-3">Data Semua Pengguna</h3>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= $u['name'] ?></td>
                            <td><?= $u['username'] ?></td>
                            <td><?= $u['email'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <h1 class="display-4">Selamat datang, <?= $user['name'] ?></h1> 
            <p class="lead">Ini adalah halaman dashboard untuk pengguna biasa.</p>
            <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
            
            <h3 class="mt-5 mb-3">Data Anda</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td><?= $user['name'] ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= $user['username'] ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $user['email'] ?></td>  
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?= $user['gender'] ?></td>
                </tr>
                <tr>
                    <th>Fakultas</th>
                    <td><?= $user['faculty'] ?></td>    
                </tr>
                <tr>
                    <th>Angkatan</th>
                    <td><?= $user['batch'] ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</body>
</html>
