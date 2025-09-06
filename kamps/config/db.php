<?php
require_once __DIR__ . '/../config/config.php';

function db(): PDO {
  static $pdo = null;
  if ($pdo === null) {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $opts = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
  }
  return $pdo;
}

function dbQuery(string $query, array $params = []): PDOStatement {
  try {
    $stmt = db()->prepare($query);
    $stmt->execute($params);
    return $stmt;
  } catch (PDOException $e) {
    // Log or display a more informative error message
    throw new PDOException(
      "Database query error: " . $e->getMessage() . " | Query: $query | Params: " . json_encode($params),
      (int)$e->getCode(),
      $e
    );
  }
}




