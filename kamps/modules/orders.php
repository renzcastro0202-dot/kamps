<?php
require_once __DIR__ . '/../includes/auth_helper.php';

$current_user_role = $_SESSION['role'] ?? 'guest';

if (!has_permission($current_user_role, 'manage_orders')) {
    die('Access denied.');
}

// ...existing code...