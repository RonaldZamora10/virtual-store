<?php
require_once '../db.php';

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM TBL_Metodos_Pago WHERE id_metodo_pago = ?");
    $stmt->execute(array($id));
    $metodo_pago = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE TBL_Metodos_Pago SET nombre_metodo = :nombre WHERE id_metodo_pago = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $id,
        ':nombre' => $nombre
    ));
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $editing ? 'Editar Método de Pago' : 'Agregar Método de Pago'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h2 class="fw-bold"><?php echo $editing ? 'Editar Método de Pago' : 'Agregar Método de Pago'; ?></h2>
        <p class="text-muted mb-4">Actualiza la información del método de pago seleccionado.</p>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" name="id" value="<?php echo $editing ? $metodo_pago['id_metodo_pago'] : ''; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Método</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="<?php echo $editing ? htmlspecialchars($metodo_pago['nombre_metodo']) : ''; ?>" required>
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
