<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function require_role($roles = []) {
    require_login();

    if (!in_array($_SESSION['user']['role'], (array)$roles)) {
        http_response_code(403);
        exit("Akses ditolak! Role diperlukan: " . implode(", ", $roles));
    }
}
