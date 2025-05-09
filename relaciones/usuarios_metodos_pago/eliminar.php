<?php
require_once '../db.php';

if (isset($_GET['delete_id']) && isset($_GET['metodo_id'])) {
    $id_usuario = $_GET['delete_id'];
    $id_metodo_pago = $_GET['metodo_id'];
    $stmt = $pdo->prepare("DELETE FROM TBL_Usuarios_Metodos_Pago WHERE id_usuario = ? AND id_metodo_pago = ?");
    $stmt->execute(array($id_usuario, $id_metodo_pago));
    header("Location: listar.php");
    exit();
}
?>
