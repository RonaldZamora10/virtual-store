<?php

require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tienda Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
        }

        .card-icon {
            font-size: 2.5rem;
            color: #000;
        }

        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.02);
            border-color: #0d6efd;
        }

        .nav-link {
            font-weight: 500;
        }
    </style>
</head>

<body>
    <?php include '../tienda_virtual_crud/navbar.php'; ?>

    <div class="container text-center my-5">
        <h1 class="fw-bold">Bienvenido a la Tienda Virtual</h1>
        <p class="text-muted">Sistema de administración para tu tienda en línea</p>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <a href="productos/listar.php" class="text-decoration-none text-dark">
                    <div class="card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Productos</h5>
                                <p class="text-muted">Gestiona el inventario de productos</p>
                            </div>
                            <i class="bi bi-box card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="categorias/listar.php" class="text-decoration-none text-dark">
                    <div class="card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Categorías</h5>
                                <p class="text-muted">Organiza tus productos por categorías</p>
                            </div>
                            <i class="bi bi-grid card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="relaciones/pedidos_productos/listar.php" class="text-decoration-none text-dark">
                    <div class="card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Relación Productos y Pedidos</h5>
                                <p class="text-muted">Administra las productos en los pedidos</p>
                            </div>
                            <i class="bi bi-person card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="pedidos/listar.php" class="text-decoration-none text-dark">
                    <div class="card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Pedidos</h5>
                                <p class="text-muted">Visualiza y gestiona los pedidos</p>
                            </div>
                            <i class="bi bi-cart card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="metodos_pago/listar.php" class="text-decoration-none text-dark">
                    <div class="card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Métodos de Pago</h5>
                                <p class="text-muted">Configura los métodos de pago disponibles</p>
                            </div>
                            <i class="bi bi-credit-card card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>