<?php
session_start();

$host = 'localhost';
$dbname = 'sklep';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch(PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserName() {
    return $_SESSION['username'] ?? 'Gość';
}
?>