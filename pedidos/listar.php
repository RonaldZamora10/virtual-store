<?php
require_once '../db.php';

$stmt = $pdo->query("SELECT * FROM TBL_Pedidos ORDER BY id_pedido DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Listado de Pedidos</h2>
                <p class="text-muted mb-0">Visualiza, edita o elimina los pedidos realizados en tu tienda</p>
            </div>
            <a href="agregar.php" class="btn btn-dark">
                <i class="bi bi-plus-lg"></i> Nuevo Pedido
            </a>
        </div>

        <div class="card">
            <div class="card-body" style="height: calc(100vh - 230px);">
                <h5 class="fw-semibold">Lista de Pedidos</h5>
                <p class="text-muted">Visualiza, edita o elimina los pedidos en tu tienda</p>
                <div class="table-responsive" style="height: 85%;">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">ID Usuario</th>
                                <th scope="col">Costo</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo $row['id_pedido']; ?></td>
                                    <td><?php echo $row['id_usuario']; ?></td>
                                    <td>$<?php echo number_format($row['costo_pedido'], 2); ?></td>
                                    <td><?php echo $row['ciudad_pedido']; ?></td>
                                    <td><?php echo $row['estado_pedido']; ?></td>
                                    <td><?php echo $row['fecha_pedido']; ?></td>
                                    <td><?php echo $row['hora_pedido']; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="editar.php?edit_id=<?php echo $row['id_pedido']; ?>">
                                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="eliminar.php?delete_id=<?php echo $row['id_pedido']; ?>"
                                                       onclick="return confirm('¿Seguro que deseas eliminar este pedido?')">
                                                        <i class="bi bi-trash3 me-1"></i> Eliminar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
