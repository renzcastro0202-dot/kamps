<?php
// /database/seed_permissions.php
require_once __DIR__ . '/../config/db.php';

$permissions = [
    'manage_users',
    'manage_categories',
    'manage_items',
    'manage_orders',
    'view_items',
];

try {
    foreach ($permissions as $perm) {
        dbQuery("INSERT IGNORE INTO permissions (name) VALUES (?)", [$perm]);
    }
    echo "✅ Permissions seeded successfully\n";
} catch (Exception $e) {
    echo "❌ Error seeding permissions: " . $e->getMessage() . "\n";
}
