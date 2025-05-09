<?php
require_once '../../db.php';

if (isset($_GET['delete_id']) && isset($_GET['producto_id'])) {
    $id_pedido = $_GET['delete_id'];
    $id_producto = $_GET['producto_id'];

    $stmt = $pdo->prepare("SELECT cantidad FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));
    $cantidad_producto = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT stock_producto FROM tbl_productos WHERE id_producto = ?");
    $stmt->execute(array($id_producto));
    $stock_actual = (int) $stmt->fetchColumn();

    $nuevo_stock = $stock_actual + $cantidad_producto;
    $stmt = $pdo->prepare("UPDATE tbl_productos SET stock_producto = ? WHERE id_producto = ?");
    $stmt->execute(array($nuevo_stock, $id_producto));

    $stmt = $pdo->prepare("DELETE FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));

    header("Location: listar.php");
    exit();
}
?>
