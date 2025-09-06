<?php
require_once __DIR__ . '/auth_helper.php';

// Check if current user can approve/reject a given role
function canApproveUserRole($targetRole) {
    $me = current_user();
    if (!$me) return false;

    // Super Admin can approve/reject all
    if ($me['role'] === 'super_admin') {
        return true;
    }

    // Admin can approve/reject everyone EXCEPT super_admin
    if ($me['role'] === 'admin' && $targetRole !== 'super_admin') {
        return true;
    }

    // Staff & Guests cannot approve
    return false;
}
