<?php
// /database/seed_role_permissions.php
require_once __DIR__ . '/../config/db.php';

// Role → Permissions mapping
$rolePermissions = [
    'super_admin' => ['manage_users', 'manage_categories', 'manage_items', 'manage_orders', 'view_items'],
    'admin'       => ['manage_categories', 'manage_items', 'manage_orders', 'view_items'],
    'staff'       => ['manage_orders', 'view_items'],
    'guest'       => ['view_items'],
];

try {
    foreach ($rolePermissions as $role => $perms) {
        // Get role_id
        $role_id = dbQuery("SELECT id FROM roles WHERE name = ?", [$role])->fetchColumn();

        if (!$role_id) continue;

        foreach ($perms as $perm) {
            $perm_id = dbQuery("SELECT id FROM permissions WHERE name = ?", [$perm])->fetchColumn();
            if ($perm_id) {
                dbQuery("INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (?, ?)", [$role_id, $perm_id]);
            }
        }
    }

    echo "✅ Role permissions seeded successfully\n";
} catch (Exception $e) {
    echo "❌ Error seeding role permissions: " . $e->getMessage() . "\n";
}
