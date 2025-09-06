<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user']['full_name'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'unknown';

// Redirect target based on role
$dashboards = [
    'super_admin' => '../public/super_admin_dashboard.php',
    'admin'       => '../public/admin_dashboard.php',
    'staff'       => '../public/staff_dashboard.php',
    'guest'       => '../public/guest_dashboard.php',
];

// Default if role unknown
$redirect = $dashboards[$role] ?? '../public/login.php';

// Get flash message (if any)
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Access Denied – Kape Agosto</title>
  <style>
    body {
      margin:0; font-family: Arial, sans-serif;
      display:flex; justify-content:center; align-items:center;
      height:100vh; background:#f8f5f0;
    }
    .card {
      background:#fff; padding:30px; border-radius:12px;
      box-shadow:0 8px 20px rgba(0,0,0,.2);
      text-align:center; max-width:420px;
    }
    h1 { color:#c0392b; margin-bottom:10px; }
    p { margin:8px 0; color:#333; }
    .flash {
      margin: 10px 0; padding: 12px;
      border-radius: 8px;
      background: #ffd9d9; color: #6b1111;
      border: 1px solid #f3b2b2;
      font-size: 14px;
    }
    a {
      display:inline-block; margin-top:20px;
      padding:10px 18px; border-radius:8px;
      background:#c7922b; color:#fff; text-decoration:none;
      font-weight:600;
    }
    a:hover { opacity:.9; }
  </style>
  <!-- Op
