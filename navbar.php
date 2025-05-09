<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
    exit();
}
$nombre_usuario = $_SESSION['usuario']['nombre_usuario'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm d-flex justify-content-center">
    <div class="container m-0 p-0" style="gap: 5rem;">
        <a class="navbar-brand d-flex align-items-center" href="/tienda_virtual_crud/index.php">
            <i class="bi bi-shop me-2"></i> Tienda Virtual
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/tienda_virtual_crud/productos/listar.php">Productos</a>
                </li>
                <li class="nav-item"><a class="nav-link"
                        href="/tienda_virtual_crud/categorias/listar.php">Categorías</a></li>
                </li>
                <li class="nav-item"><a class="nav-link" href="/tienda_virtual_crud/pedidos/listar.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="/tienda_virtual_crud/metodos_pago/listar.php">Métodos de
                        Pago</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="/tienda_virtual_crud/relaciones/pedidos_productos/listar.php">Pedidos Productos</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="/tienda_virtual_crud/relaciones/usuarios_metodos_pago/listar.php">Métodos Pago
                        Usuarios</a></li>
            </ul>
        </div>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?php echo $nombre_usuario; ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/tienda_virtual_crud/logout.php" id="logoutButton">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>