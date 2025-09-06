<?php
// includes/sidebar.php
require_once __DIR__ . '/auth_helper.php';
require_once __DIR__ . '/role_permissions.php';

$me   = current_user();
$role = $me['role'] ?? 'guest';
?>

<aside style="width:250px; background:#222; color:#fff; height:100vh; padding:20px; position:fixed;">
    <h2 style="color:#f9c74f;">KAMPS</h2>
    <nav>
        <ul style="list-style:none; padding:0; margin:20px 0;">
            
            <li style="margin:10px 0;">
                <a href="/public/dashboard.php" style="color:#fff; text-decoration:none;">📊 Dashboard</a>
            </li>

            <?php if (hasPermission($role, 'manage_users')): ?>
            <li style="margin:10px 0;">
                <a href="/public/manage_users.php" style="color:#fff; text-decoration:none;">👥 Manage Users</a>
            </li>
            <?php endif; ?>

            <?php if ($role === 'super_admin' && hasPermission($role, 'manage_roles')): ?>
            <li style="margin:10px 0;">
                <a href="/public/manage_roles.php" style="color:#fff; text-decoration:none;">🛡️ Manage Roles</a>
            </li>
            <?php endif; ?>

            <?php if (hasPermission($role, 'manage_categories')): ?>
            <li style="margin:10px 0;">
                <a href="/public/categories.php" style="color:#fff; text-decoration:none;">📂 Categories</a>
            </li>
            <?php endif; ?>

            <?php if (hasPermission($role, 'manage_items')): ?>
            <li style="margin:10px 0;">
                <a href="/public/items.php" style="color:#fff; text-decoration:none;">📦 Items</a>
            </li>
            <?php endif; ?>

            <?php if (hasPermission($role, 'manage_orders')): ?>
            <li style="margin:10px 0;">
                <a href="/public/orders.php" style="color:#fff; text-decoration:none;">📝 Orders</a>
            </li>
            <?php endif; ?>

            <?php if (hasPermission($role, 'view_items') && $role === 'guest'): ?>
            <li style="margin:10px 0;">
                <a href="/public/items.php" style="color:#fff; text-decoration:none;">👀 View Items</a>
            </li>
            <?php endif; ?>

            <li style="margin:10px 0; border-top:1px solid #444; padding-top:10px;">
                <a href="/public/logout.php" style="color:#ff6b6b; text-decoration:none;">🚪 Logout</a>
            </li>
        </ul>
    </nav>
</aside>
