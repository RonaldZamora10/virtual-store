<?php
require_once '../../db.php';

$editing = false;
if (isset($_GET['edit_id']) && isset($_GET['producto_id'])) {
    $editing = true;
    $id_pedido = $_GET['edit_id'];
    $id_producto = $_GET['producto_id'];

    $stmt = $pdo->prepare("SELECT * FROM TBL_Rel_Pedidos_Productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));
    $relacion = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['actualizar'])) {
    $id_pedido = $_POST['id_pedido'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE TBL_Rel_Pedidos_Productos 
            SET cantidad = :cantidad 
            WHERE id_pedido = :id_pedido AND id_producto = :id_producto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id_pedido' => $id_pedido,
        ':id_producto' => $id_producto,
        ':cantidad' => $cantidad
    ));

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= $editing ? 'Editar Relación Pedido-Producto' : 'Agregar Relación Pedido-Producto' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <h2 class="fw-bold mb-4"><?= $editing ? 'Editar Relación Pedido-Producto' : 'Agregar Relación Pedido-Producto' ?></h2>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <input  name="id_pedido" value="<?= $editing ? $relacion['id_pedido'] : '' ?>">
            <input  name="id_producto" value="<?= $editing ? $relacion['id_producto'] : '' ?>">

            <div class="mb-3">
                <label class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" value="<?= $editing ? $relacion['cantidad'] : '' ?>" min="1" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="actualizar" class="btn btn-dark"><?= $editing ? 'Actualizar' : 'Agregar' ?></button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
