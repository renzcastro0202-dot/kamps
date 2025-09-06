<?php
require_once __DIR__ . '/../config/db.php';

// Hash password
$hashed = password_hash("SuperAdmin123!", PASSWORD_DEFAULT);

// Insert or update superadmin
$sql = "
INSERT INTO users (username, password, full_name, email, contact, role_id, status)
SELECT 
  'superadmin',
  ?,
  'Super Administrator',
  'superadmin@example.com',
  '09123456789',
  id,
  'active'
FROM roles
WHERE name = 'super_admin'
ON DUPLICATE KEY UPDATE
  password   = VALUES(password),
  full_name  = VALUES(full_name),
  email      = VALUES(email),
  contact    = VALUES(contact),
  role_id    = VALUES(role_id),
  status     = VALUES(status)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed);
$stmt->execute();
$stmt->close();

echo "✅ Superadmin created/updated. Username: superadmin | Password: SuperAdmin123!";
