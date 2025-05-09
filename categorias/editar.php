<?php
require_once '../db.php';

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM TBL_Categorias WHERE id_categoria = ?");
    $stmt->execute(array($id));
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE TBL_Categorias SET nombre_categoria=:nombre WHERE id_categoria=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $id,
        ':nombre' => $nombre,
    ));
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $editing ? 'Editar Categoría' : 'Agregar Categoría'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h2 class="fw-bold"><?php echo $editing ? 'Editar Categoría' : 'Agregar Categoría'; ?></h2>
        <p class="text-muted mb-4">
            <?php echo $editing ? 'Modifica los datos de la categoría seleccionada.' : 'Introduce el nombre de la nueva categoría.'; ?>
        </p>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" name="id" value="<?php echo $editing ? $categoria['id_categoria'] : ''; ?>">

            <div class="mb-3">
                <label class="form-label">Nombre de la categoría</label>
                <input type="text" name="nombre" class="form-control" required
                    value="<?php echo $editing ? $categoria['nombre_categoria'] : ''; ?>">
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="actualizar" class="btn btn-dark">
                    <?php echo $editing ? 'Actualizar Categoría' : 'Agregar Categoría'; ?>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
