<?php
require_once '../db.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM TBL_Productos WHERE id_producto = ?");
    $stmt->execute(array($id));
    header("Location: listar.php");
    exit();
}
?>
