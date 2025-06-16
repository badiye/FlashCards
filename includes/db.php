<?php

$host = 'localhost';
$db   = 'flashcards';
$user = 'root';
$pass = 'root123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=flashcards", "root", "root123");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
