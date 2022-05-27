<?php

$host       = "localhost";
$db         = "blog";
$user       = "root";
$pass       = "root";
$charset    = "utf8mb4";

$dsn        = "mysql:host={$host};dbname={$db};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //SILENT      
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, null);
}   catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}