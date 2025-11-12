<?php
// auth.php
session_start();

function is_logged_in() {
    return !empty($_SESSION['user']['id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php'); exit;
    }
}

// cek role
function require_role($roles = []) {
    if (!is_logged_in()) header('Location: login.php');
    $userRole = $_SESSION['user']['role'] ?? 'user';
    if (!in_array($userRole, (array)$roles, true)) {
        // 403 Forbidden
        http_response_code(403);
        echo "Akses ditolak. Anda memerlukan role: " . implode(',', (array)$roles);
        exit;
    }
}
