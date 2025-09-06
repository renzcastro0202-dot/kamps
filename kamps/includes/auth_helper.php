<?php
// includes/auth_helper.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function require_login(): void {
    if (!current_user()) {
        header("Location: /public/login.php");
        exit;
    }
}

function require_admin(): void {
    $user = current_user();
    if (!$user || !in_array($user['role'], ['super_admin', 'admin'])) {
        header("Location: /public/login.php");
        exit;
    }
}

function require_super_admin(): void {
    $user = current_user();
    if (!$user || $user['role'] !== 'super_admin') {
        header("Location: /public/login.php");
        exit;
    }
}

function logout_users(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Clear all session variables
    $_SESSION = [];

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally destroy the session
    session_destroy();
}

