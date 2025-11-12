<?php
// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
}
$csrf_token = $_SESSION['csrf_token'];

$err     = $_SESSION['error']   ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tambah User (Admin)</title>
  <style>
    body { font-family: Arial, sans-serif; max-width:650px; margin:auto; padding:20px; }
    form { background:#f3f3f3; padding:16px; border-radius:6px; }
    label { display:block; margin-bottom:10px; }
    input, select { width:100%; padding:8px; margin-top:4px; }
    .err { color:red; }
    .ok  { color:green; }
  </style>
</head>
<body>

<h2>Tambah User (Admin)</h2>

<?php if ($err): ?>
  <p class="err"><?=htmlspecialchars($err)?></p>
<?php endif; ?>

<?php if ($success): ?>
  <p class="ok"><?=htmlspecialchars($success)?></p>
<?php endif; ?>

<form method="post" action="actions/add_user_action.php">
  <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf_token)?>">

  <label>
    Nama lengkap
    <input type="text" name="nama" required>
  </label>

  <label>
    NIP
    <input type="text" name="nip" required>
  </label>

  <label>
    Password
    <input type="password" name="password" required>
  </label>

  <label>
    Role
    <select name="role">
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
  </label>

  <button type="submit">Tambah User</button>
</form>

<br>
<a href="dashboard.php">Dashboard</a> |
<a href="logout.php">Logout</a>

</body>
</html>
