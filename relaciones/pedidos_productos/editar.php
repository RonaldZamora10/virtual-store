<?php
require_once '../../db.php';

$editing = false;

if (isset($_GET['edit_id']) && isset($_GET['producto_id'])) {
    $editing = true;
    $id_pedido = $_GET['edit_id'];
    $id_producto = $_GET['producto_id'];

    $stmt = $pdo->prepare("
        SELECT rel.*, p.fecha_pedido, pr.nombre_producto, pr.stock_producto 
        FROM tbl_rel_pedidos_productos rel
        JOIN tbl_pedidos p ON p.id_pedido = rel.id_pedido
        JOIN tbl_productos pr ON pr.id_producto = rel.id_producto
        WHERE rel.id_pedido = ? AND rel.id_producto = ?
    ");
    $stmt->execute(array($id_pedido, $id_producto));
    $relacion = $stmt->fetch(PDO::FETCH_ASSOC);
    $stock_total = $relacion['stock_producto'] + $relacion['cantidad'];
}

if (isset($_POST['actualizar'])) {
    $id_pedido = $_POST['id_pedido'];
    $id_producto = $_POST['id_producto'];
    $cantidad = (int) $_POST['cantidad'];

    $stmt = $pdo->prepare("SELECT stock_producto FROM tbl_productos WHERE id_producto = ?");
    $stmt->execute(array($id_producto));
    $stock = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT cantidad FROM tbl_rel_pedidos_productos WHERE id_pedido = ? AND id_producto = ?");
    $stmt->execute(array($id_pedido, $id_producto));
    $cantidad_actual = (int) $stmt->fetchColumn();

    $stock_total = $stock + $cantidad_actual;

    if ($cantidad <= 0 || $cantidad > $stock_total) {
        $error = "La cantidad debe ser mayor que 0 y no superar el stock disponible ($stock_total).";
    } else {
        $sql = "UPDATE tbl_rel_pedidos_productos SET cantidad = :cantidad WHERE id_pedido = :id_pedido AND id_producto = :id_producto";
        
        $stmt = $pdo->prepare("UPDATE tbl_productos SET stock_producto = stock_producto - ? WHERE id_producto = ?");
        $stmt->execute(array($cantidad, $id_producto));

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':id_pedido' => $id_pedido,
            ':id_producto' => $id_producto,
            ':cantidad' => $cantidad
        ));

        header("Location: listar.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Relación Pedido-Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Editar Relación Pedido-Producto</h5>
            </div>
            <div class="card-body">
                <?php if ($editing && $relacion): ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="id_pedido" value="<?php echo $relacion['id_pedido']; ?>">
                        <input type="hidden" name="id_producto" value="<?php echo $relacion['id_producto']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Producto:</label>
                            <input type="text" class="form-control" value="<?php echo $relacion['nombre_producto']; ?>"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha del Pedido:</label>
                            <input type="text" class="form-control" value="<?php echo $relacion['fecha_pedido']; ?>"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad (máx: <?php echo $stock_total; ?>):</label>
                            <input type="number" name="cantidad" class="form-control"
                                value="<?php echo $relacion['cantidad']; ?>" min="1" max="<?php echo $stock_total; ?>"
                                required>
                        </div>

                        <button type="submit" name="actualizar" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Actualizar
                        </button>
                        <a href="listar.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger">No se encontró la relación a editar.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>