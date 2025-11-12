<?php
session_start();

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit();
    } else {
        header('Location: user/dashboard.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h2 align="center">Welcome to web123</h2>
    <p align="center">
        <a href="login.php" align="center">Login</a>
    </p>
    
    <p align="center"> 
        <img src="https://i.redd.it/bpxxqqvps4h91.gif" width="600"> 
    </p>
</body>
</html>