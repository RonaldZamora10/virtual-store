<?php
require_once '../../db.php';

if (isset($_POST['agregar'])) {
    $id_usuario = $_POST['id_usuario'];
    $id_metodo_pago = $_POST['id_metodo_pago'];

    $sql = "INSERT INTO TBL_Usuarios_Metodos_Pago (id_usuario, id_metodo_pago)
            VALUES (:id_usuario, :id_metodo_pago)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id_usuario' => $id_usuario,
        ':id_metodo_pago' => $id_metodo_pago
    ));
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Relación Usuario-Método de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <h2 class="fw-bold mb-4">Agregar Relación Usuario-Método de Pago</h2>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="id_usuario" class="form-label">ID Usuario</label>
                <input type="text" name="id_usuario" id="id_usuario" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="id_metodo_pago" class="form-label">ID Método de Pago</label>
                <input type="text" name="id_metodo_pago" id="id_metodo_pago" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="agregar" class="btn btn-dark">Agregar</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
