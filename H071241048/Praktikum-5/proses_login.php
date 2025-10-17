<?php 
    session_start();
    include 'data.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? ''; 

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        }
    }
    $_SESSION['error'] = "Username atau Password salah";
    header("Location: login.php");
    exit;

?>