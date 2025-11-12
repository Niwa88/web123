<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $sql = "SELECT id, nama_lengkap, password, role FROM pengguna WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email'=>$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        // regenerasi session id untuk mencegah fixation
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nama' => $user['nama_lengkap'],
            'email' => $email,
            'role' => $user['role'],
            'login_time' => time()
        ];
        header('Location: dashboard.php'); exit;
    } else {
        $err = "Email atau password salah.";
    }
}
?>
<form method="post">
  <label>Email<br><input name="email"></label><br>
  <label>Password<br><input name="password" type="password"></label><br>
  <button type="submit">Login</button>
  <?php if (!empty($err)) echo "<p style='color:red;'>$err</p>"; ?>
</form>
