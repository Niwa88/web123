<?php
require 'auth.php';
require_role(['admin']);
?>
<h2>Halaman Admin</h2>
<a href="admin_add_user.php">Tambah User</a>
<p>Hanya admin yang bisa membuka halaman ini.</p>

<a href="dashboard.php">Kembali</a>