<?php
require_once '../db.php';

if (isset($_GET['delete_id'])) {
    $id_pedido = $_GET['delete_id'];
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT id_producto, cantidad FROM tbl_rel_pedidos_productos WHERE id_pedido = ?");
        $stmt->execute(array($id_pedido));
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productos as $prod) {
            $stmt = $pdo->prepare("UPDATE tbl_productos SET stock_producto = stock_producto + ? WHERE id_producto = ?");
            $stmt->execute(array($prod['cantidad'], $prod['id_producto']));
        }

        $stmt = $pdo->prepare("DELETE FROM tbl_rel_pedidos_productos WHERE id_pedido = ?");
        $stmt->execute(array($id_pedido));

        $stmt = $pdo->prepare("DELETE FROM tbl_pedidos WHERE id_pedido = ?");
        $stmt->execute(array($id_pedido));

        $pdo->commit();
        header("Location: listar.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error al eliminar pedido: " . $e->getMessage();
    }
}
?>
