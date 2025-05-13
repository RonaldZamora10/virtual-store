<?php
require_once '../../db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['delete_id']) && isset($_GET['producto_id'])) {
    $id_pedido = $_GET['delete_id'];
    $id_producto = $_GET['producto_id'];
    $stmt = $pdo->prepare("SELECT cantidad FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));
    $cantidad_producto = $stmt->fetchColumn();

    if ($cantidad_producto === false) {
        die("No se encontró la relación para eliminar.");
    }

    $stmt = $pdo->prepare("SELECT stock_producto FROM tbl_productos WHERE id_producto = ?");
    $stmt->execute(array($id_producto));
    $stock_actual = $stmt->fetchColumn();

    if ($stock_actual === false) {
        die("No se encontró el producto.");
    }

    $nuevo_stock = (int)$stock_actual + (int)$cantidad_producto;
    $stmt = $pdo->prepare("UPDATE tbl_productos SET stock_producto = ? WHERE id_producto = ?");
    $stmt->execute(array($nuevo_stock, $id_producto));
    $stmt = $pdo->prepare("DELETE FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ?");
    $stmt->execute(array($id_pedido));
    $cantidad_restante = $stmt->fetchColumn();

    if ((int)$cantidad_restante === 0) {
        $stmt = $pdo->prepare("DELETE FROM tbl_pedidos WHERE id_pedido = ?");
        $stmt->execute(array($id_pedido));
    }

    header("Location: listar.php");
    exit();
}
?>
