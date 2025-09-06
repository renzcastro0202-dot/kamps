<?php
// includes/topbar.php

$currentUser = current_user();
?>
<div class="topbar">
    <div class="topbar-left">
        <h1>Kape Agosto</h1>
    </div>
    <div class="topbar-right">
        <span class="user-info">👤 <?= htmlspecialchars($currentUser['full_name'] ?? 'Guest') ?></span>
        <a href="/public/auth/logout.php" class="logout-icon" title="Logout">🚪</a>
    </div>
</div>

<style>
.topbar {
  position: fixed; left: 250px; top: 0; right: 0; height: 60px;
  background: linear-gradient(to right, #c69c6d, #a67c52);
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 20px; z-index: 999;
  color: white; font-size: 16px;
}
.topbar-left h1 { font-size: 20px; margin: 0; }
.topbar-right { display: flex; align-items: center; gap: 15px; }
.logout-icon { color:white; font-size:18px; text-decoration:none; }
.user-info { font-weight: bold; }
@media(max-width:768px){ .topbar{left:0;} }
</style>
