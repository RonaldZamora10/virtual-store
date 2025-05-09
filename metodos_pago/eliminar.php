<?php
require_once '../db.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM TBL_Metodos_Pago WHERE id_metodo_pago = ?");
    $stmt->execute(array($id));
    header("Location: listar.php");
    exit();
}
?>
