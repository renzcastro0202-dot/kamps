<?php
require_once __DIR__ . "/../config/db.php";

function getAllUsers() {
    global $pdo;
    return $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createUser($full_name, $email, $password, $role) {
    global $pdo;
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$full_name, $email, $hash, $role]);
}

function updateUser($id, $full_name, $email, $role) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=?, role=? WHERE id=?");
    return $stmt->execute([$full_name, $email, $role, $id]);
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    return $stmt->execute([$id]);
}
