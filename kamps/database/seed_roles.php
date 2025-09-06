<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Insert roles if they don't exist
    dbQuery("
        INSERT INTO roles (name)
        VALUES ('super_admin'), ('admin'), ('staff')
        ON DUPLICATE KEY UPDATE name = VALUES(name)
    ");

    echo "✅ Roles seeded successfully: super_admin, admin, staff.\n";
} catch (Exception $e) {
    echo "❌ Error seeding roles: " . $e->getMessage();
}
