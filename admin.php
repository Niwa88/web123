<?php
require 'auth.php';
require_role(['admin']);
?>
<h2>Halaman Admin</h2>
<p>Hanya admin yang bisa membuka halaman ini.</p>

<a href="dashboard.php">Kembali</a>