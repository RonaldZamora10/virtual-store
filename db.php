<?php
$host = 'localhost';
$port = '3307';
$dbname = 'tienda_virtual_crud';
$user = 'root';
$pass = 'usbw';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("❌ Error al conectar: " . $e->getMessage());
}
