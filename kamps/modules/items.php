<?php
require_once __DIR__ . "/../config/db.php";

function getAllItems() {
    global $pdo;
    $stmt = $pdo->query("SELECT i.*, c.name AS category_name 
                         FROM items i 
                         LEFT JOIN categories c ON i.category_id = c.id 
                         ORDER BY i.id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getItemById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createItem($name, $category_id, $price) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO items (name, category_id, price) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $category_id, $price]);
}

function updateItem($id, $name, $category_id, $price) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE items SET name=?, category_id=?, price=? WHERE id=?");
    return $stmt->execute([$name, $category_id, $price, $id]);
}
