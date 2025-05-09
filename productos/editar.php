<?php
require_once '../db.php';

$editing = false;
$producto = null;

$categorias = $pdo->query("SELECT id_categoria, nombre_categoria FROM TBL_Categorias")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM TBL_Productos WHERE id_producto = ?");
    $stmt->execute(array($id));
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $oferta = $_POST['oferta'];

    $sql = "UPDATE TBL_Productos SET id_categoria=:categoria, nombre_producto=:nombre, descripcion_producto=:descripcion,
            precio_producto=:precio, stock_producto=:stock, oferta_producto=:oferta WHERE id_producto=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $id,
        ':categoria' => $categoria,
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':stock' => $stock,
        ':oferta' => $oferta
    ));
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <a href="listar.php" class="text-decoration-none text-dark mb-3 d-inline-block">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h2 class="fw-bold">Editar Producto</h2>
        <p class="text-muted mb-4">Modifica los detalles del producto #<?php echo $producto['id_producto']; ?></p>

        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                        value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-select" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>" <?= ($cat['id_categoria'] == $producto['id_categoria']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre_categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control"
                        value="<?php echo $producto['precio_producto']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control"
                        value="<?php echo $producto['stock_producto']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"
                    rows="3"><?php echo htmlspecialchars($producto['descripcion_producto']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Oferta</label>
                <input type="text" name="oferta" class="form-control"
                    value="<?php echo $producto['oferta_producto']; ?>">
            </div>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" name="actualizar" class="btn btn-dark">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>