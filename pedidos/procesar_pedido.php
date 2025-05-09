<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id_usuario'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$zip = $_POST['zip'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$estado = 'pendiente';

$productos = $_POST['productos'];
$costo_total = 0;

foreach ($productos as $prod) {
    $costo_total += floatval($prod['subtotal']);
}

$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare("INSERT INTO tbl_pedidos (id_usuario, ciudad_pedido, direccion_pedido, zip_pedido, estado_pedido, fecha_pedido, hora_pedido, costo_pedido)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($id_usuario, $ciudad, $direccion, $zip, $estado, $fecha, $hora, $costo_total));
    $id_pedido = $pdo->lastInsertId();

    foreach ($productos as $prod) {
        $id_producto = $prod['id_producto'];
        $cantidad = $prod['cantidad'];
        $subtotal = $prod['subtotal'];

        $stmt = $pdo->prepare("INSERT INTO tbl_rel_pedidos_productos (id_pedido, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($id_pedido, $id_producto, $cantidad, $subtotal));

        $stmt = $pdo->prepare("UPDATE tbl_productos SET stock_producto = stock_producto - ? WHERE id_producto = ? AND stock_producto >= ?");
        $stmt->execute(array($cantidad, $id_producto, $cantidad));
    }

    $pdo->commit();
    header("Location: listar.php");
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
