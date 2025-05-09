<?php
require_once '../db.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO TBL_Categorias (nombre_categoria) VALUES (:nombre)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':nombre' => $nombre));

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h2 class="fw-bold">Agregar Categoría</h2>
        <p class="text-muted mb-4">Introduce el nombre de la nueva categoría.</p>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label class="form-label">Nombre de la categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="agregar" class="btn btn-dark">Agregar Categoría</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
