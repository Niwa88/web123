<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nip  = trim($_POST['nip'] ?? '');
    $pass = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE nip = :nip LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nip' => $nip]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'   => $user['id'],
            'nama' => $user['nama_lengkap'],
            'nip'  => $user['nip'],
            'role' => $user['role']
        ];

        header("Location: dashboard.php");
        exit;

    } else {
        $err = "NIP atau Password salah.";
    }
}
?>

<form method="post">

    <table>
        <tr>
            <td>NIP</td>
            <td><input name="nip" placeholder="Masukan NIP"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="password" type="password" placeholder="Masukan Password"></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Login</button></td>
        </tr>
    </table>     
    <?php if (!empty($err)) echo "<p style='color:red;'>$err</p>"; ?>
</form>
