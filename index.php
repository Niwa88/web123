<?php
session_start();

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: admin/admin_dashboard.php');
        exit();
    } else {
        header('Location: user/user_dashboard.php');
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
    <h2>Selamat datang</h2>
    <a href="login.php">Login</a>
</body>
</html>