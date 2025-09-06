<?php
require_once __DIR__ . "/../includes/auth_helper.php";
require_once __DIR__ . "/../includes/role_permissions.php";

require_login();
$user = current_user();
$role = $user['role'];

// Redirect kung hindi admin
if ($role !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Kape Agosto</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0; }
    header { background: #a67c52; padding: 15px; color: #fff; }
    .container { padding: 20px; }
    h1 { margin-bottom: 20px; }
    ul { list-style: none; padding: 0; }
    li { margin: 10px 0; }
    a {
      display: inline-block;
      padding: 10px 14px;
      background: #333;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: 0.3s ease;
    }
    a:hover { background: #555; }
    .logout { background: #a11; }
  </style>
</head>
<body>
  <header>
    <h2>☕ Kape Agosto - Admin Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($user['full_name']) ?> 
       (Role: <?= htmlspecialchars(ucfirst($role)) ?>)</p>
  </header>

  <div class="container">
    <h1>📌 Available Modules</h1>
    <ul>
      <?php if (hasPermission($role, 'manage_users')): ?>
        <li><a href="../modules/users.php">👥 Manage Users</a></li>
      <?php endif; ?>

      <?php if (hasPermission($role, 'manage_categories')): ?>
        <li><a href="../modules/categories.php">📂 Manage Categories</a></li>
      <?php endif; ?>

      <?php if (hasPermission($role, 'manage_items')): ?>
        <li><a href="../modules/items.php">🍵 Manage Items</a></li>
      <?php endif; ?>

      <?php if (hasPermission($role, 'manage_orders')): ?>
        <li><a href="../modules/orders.php">🧾 Manage Orders</a></li>
      <?php endif; ?>

      <?php if (hasPermission($role, 'view_items')): ?>
        <li><a href="../modules/view_items.php">👀 View Items</a></li>
      <?php endif; ?>
    </ul>

    <a class="logout" href="../auth/logout.php">🚪 Logout</a>
  </div>
</body>
</html>
