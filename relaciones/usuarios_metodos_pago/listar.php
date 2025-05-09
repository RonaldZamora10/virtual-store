<?php
require_once '../../db.php';

$stmt = $pdo->query("SELECT * FROM TBL_Usuarios_Metodos_Pago ORDER BY id_usuario DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios-Métodos de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include '../../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-4">Listado de Usuarios-Métodos de Pago</h2>
                <p class="text-muted mb-0">Gestiona el listado de los metodos de pago de Usuarios</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>ID Método de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['id_usuario']; ?></td>
                        <td><?php echo $row['id_metodo_pago']; ?></td>
                        <td>
                            <a href="editar.php?edit_id=<?php echo $row['id_usuario']; ?>&metodo_id=<?php echo $row['id_metodo_pago']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            |
                            <a href="eliminar.php?delete_id=<?php echo $row['id_usuario']; ?>&metodo_id=<?php echo $row['id_metodo_pago']; ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>