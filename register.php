<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$nama || !$email || !$pass) {
        $err = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Email tidak valid.";
    } else {
        // hash password
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO pengguna (nama_lengkap, email, password) VALUES (:nama, :email, :pass)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([':nama'=>$nama, ':email'=>$email, ':pass'=>$hash]);
            header('Location: login.php?registered=1'); exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) $err = "Email sudah terdaftar.";
            else $err = "Gagal mendaftar: " . $e->getMessage();
        }
    }
}
?>
<!-- HTML sederhana -->
<form method="post">
  <label>Nama lengkap<br><input name="nama"></label><br>
  <label>Email<br><input name="email"></label><br>
  <label>Password<br><input name="password" type="password"></label><br>
  <button type="submit">Daftar</button>
  <?php if (!empty($err)) echo "<p style='color:red;'>$err</p>"; ?>
</form>