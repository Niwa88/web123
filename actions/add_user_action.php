<?php
require '../auth.php';
require_role(['admin']);
require '../db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_add_user.php');
    exit;
}

// --- CSRF ---
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Token CSRF tidak valid.";
    header('Location: ../admin_add_user.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$nip  = trim($_POST['nip'] ?? '');
$pass = $_POST['password'] ?? '';
$role = in_array($_POST['role'] ?? 'user', ['user','admin']) ? $_POST['role'] : 'user';

if ($nama === '' || $nip === '' || $pass === '') {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header('Location: ../admin_add_user.php');
    exit;
}

if (strlen($pass) < 6) {
    $_SESSION['error'] = "Password minimal 6 karakter.";
    header('Location: ../admin_add_user.php');
    exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO users (nama_lengkap, nip, password, role)
            VALUES (:nama, :nip, :pass, :role)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nama' => $nama,
        ':nip'  => $nip,
        ':pass' => $hash,
        ':role' => $role
    ]);

    $_SESSION['success'] = "User berhasil ditambahkan.";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $_SESSION['error'] = "NIP sudah terdaftar.";
    } else {
        $_SESSION['error'] = "DB Error: " . $e->getMessage();
    }
}

header("Location: ../admin_add_user.php");
exit;
