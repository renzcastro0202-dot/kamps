<?php
require_once __DIR__ . '/../includes/auth_helper.php';

$current_user_role = $_SESSION['role'] ?? 'guest';

if (!has_permission($current_user_role, 'view_items')) {
    die('Access denied.');
}

// ...existing code to display items...
?>