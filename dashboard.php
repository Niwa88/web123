<?php
require 'auth.php';
require_login();
?>

<h2>Selamat datang, <?=htmlspecialchars($_SESSION['user']['nama'])?></h2>
<p>NIP: <?=htmlspecialchars($_SESSION['user']['nip'])?></p>
<p>Role: <?=htmlspecialchars($_SESSION['user']['role'])?></p>

<a href="admin.php">Halaman Admin</a> |
<a href="logout.php">Logout</a>
