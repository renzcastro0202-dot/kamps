<?php
// Centralized role → permissions mapping
$rolePermissions = [
    'super_admin' => [
        'manage_users',
        'manage_roles',
        'manage_categories',
        'manage_items',
        'manage_orders',
        'view_items',
        'approve_users', // extra privilege
    ],
    'admin' => [
        'manage_users',
        'manage_categories',
        'manage_items',
        'manage_orders',
        'view_items',
        'approve_users', // admin can also approve (but not super_admin accounts)
    ],
    'staff' => [
        'manage_orders',
        'view_items'
    ],
    'guest' => [
        'view_items'
    ],
];

/**
 * Generic permission checker
 */
function hasPermission(string $role, string $permission): bool {
    global $rolePermissions;
    return in_array($permission, $rolePermissions[$role] ?? []);
}

/**
 * Can a user manage another user’s role?
 */
function canManageUser(string $currentRole, string $targetRole): bool {
    if ($currentRole === 'super_admin') {
        return true; // full control
    }
    if ($currentRole === 'admin' && $targetRole !== 'super_admin') {
        return true; // admin cannot manage super_admin
    }
    return false;
}

/**
 * Check if current user can approve accounts
 */
function canApproveAccounts(string $role): bool {
    return hasPermission($role, 'approve_users');
}
