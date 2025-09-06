<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_helper.php';
require_once __DIR__ . '/../includes/role_permissions.php';
require_once __DIR__ . '/../includes/flash.php';

// ✅ Require login as admin or super_admin
require_admin();

// Current user
$currentUser = current_user();

// Handle delete user
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role_id != 1"); // 🔒 Cannot delete super_admin
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        set_flash("✅ User deleted successfully.", "success");
    } else {
        set_flash("❌ Failed to delete user.", "error");
    }
    $stmt->close();

    header("Location: manage_users.php");
    exit;
}

// Fetch all users
$sql = "
    SELECT u.id, u.username, u.full_name, u.email, r.name AS role, u.status
    FROM users u
    JOIN roles r ON u.role_id = r.id
    ORDER BY u.id DESC
";
$result = $conn->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users - KAMPS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
body { font-family: 'Inter', sans-serif; margin: 20px; background: #f5f5f5; }
h1 { color: #333; }
a.button, button { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
.add { background: #007bff; color: #fff; }
.delete { background: #dc3545; color: #fff; }
.edit { background: #ffc107; color: #000; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
th { background: #f0f0f0; }
</style>
</head>
<body>
<h1>👥 Manage Users</h1>

<?php display_flash(); ?>

<a href="user_add.php" class="button add">➕ Add User</a>

<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
            <td><?= htmlspecialchars($u['status']) ?></td>
            <td>
                <?php if ($u['role'] !== 'super_admin'): ?>
                    <a href="user_edit.php?id=<?= $u['id'] ?>" class="button edit">✏ Edit</a>
                    <a href="manage_users.php?delete=<?= $u['id'] ?>" class="button delete" onclick="return confirm('Delete this user?')">🗑 Delete</a>
                <?php else: ?>
                    <span>🔒 Protected</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>
