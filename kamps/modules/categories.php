<?php
require_once __DIR__ . "/../config/db.php";

function getAllCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createCategory($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    return $stmt->execute([$name]);
}

function updateCategory($id, $name) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE categories SET name=? WHERE id=?");
    return $stmt->execute([$name, $id]);
}

function deleteCategory($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
    return $stmt->execute([$id]);
}
