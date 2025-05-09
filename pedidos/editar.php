<?php
require_once '../db.php';

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM TBL_Pedidos WHERE id_pedido = ?");
    $stmt->execute(array($id));
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $costo = $_POST['costo'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $zip = $_POST['zip'];
    $estado = $_POST['estado'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $sql = "UPDATE TBL_Pedidos SET 
                id_usuario = :id_usuario, 
                costo_pedido = :costo, 
                ciudad_pedido = :ciudad, 
                direccion_pedido = :direccion, 
                zip_pedido = :zip, 
                estado_pedido = :estado, 
                fecha_pedido = :fecha, 
                hora_pedido = :hora 
            WHERE id_pedido = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $id,
        ':id_usuario' => $id_usuario,
        ':costo' => $costo,
        ':ciudad' => $ciudad,
        ':direccion' => $direccion,
        ':zip' => $zip,
        ':estado' => $estado,
        ':fecha' => $fecha,
        ':hora' => $hora
    ));
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editing ? 'Editar Pedido' : 'Agregar Pedido'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <h2 class="fw-bold"><?php echo $editing ? 'Editar Pedido' : 'Agregar Pedido'; ?></h2>
        <form method="post" class="bg-white p-4 rounded shadow-sm">

            <input type="hidden" name="id" value="<?php echo $editing ? $pedido['id_pedido'] : ''; ?>">

            <div class="mb-3">
                <label for="id_usuario" class="form-label">ID Usuario</label>
                <input type="number" class="form-control" id="id_usuario" name="id_usuario" required
                    value="<?php echo $editing ? $pedido['id_usuario'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="costo" class="form-label">Costo</label>
                <input type="number" step="0.01" class="form-control" id="costo" name="costo" required
                    value="<?php echo $editing ? $pedido['costo_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" required
                    value="<?php echo $editing ? $pedido['ciudad_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required
                    value="<?php echo $editing ? $pedido['direccion_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="zip" class="form-label">Código Postal (ZIP)</label>
                <input type="text" class="form-control" id="zip" name="zip" required
                    value="<?php echo $editing ? $pedido['zip_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado del Pedido</label>
                <input type="text" class="form-control" id="estado" name="estado" required
                    value="<?php echo $editing ? $pedido['estado_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required
                    value="<?php echo $editing ? $pedido['fecha_pedido'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required
                    value="<?php echo $editing ? $pedido['hora_pedido'] : ''; ?>">
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="actualizar" class="btn btn-dark">Actualizar</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
