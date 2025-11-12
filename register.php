<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $nip   = trim($_POST['nip'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$nama || !$nip || !$pass) {
        $err = "Semua field wajib diisi.";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nama_lengkap, nip, password) 
                VALUES (:nama, :nip, :pass)";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':nama' => $nama,
                ':nip'  => $nip,
                ':pass' => $hash
            ]);

            echo "Registrasi berhasil. <a href='login.php'>Login</a>";
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $err = "NIP sudah terdaftar.";
            } else {
                $err = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<form method="post">
  <label>Nama lengkap<br><input name="nama"></label><br>
  <label>NIP<br><input name="nip"></label><br>
  <label>Password<br><input name="password" type="password"></label><br>
  <button type="submit">Daftar</button>
  <?php if (!empty($err)) echo "<p style='color:red;'>$err</p>"; ?>
</form>
