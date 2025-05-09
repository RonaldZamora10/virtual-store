<?php
require_once 'db.php';

function generarHash($password)
{
    $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 16);
    $hash = hash('sha256', $salt . $password);
    return $salt . ':' . $hash;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = generarHash($_POST['password']);

    $stmt = $pdo->prepare("INSERT INTO tbl_usuarios (nombre_usuario, email_usuario, password_usuario, rol_usuario)
                           VALUES (?, ?, ?, 'cliente')");
    $stmt->execute(array($nombre, $email, $password));

    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8f9fa;
        }

        .card {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="card shadow-sm rounded">
        <div class="text-center mb-4">
            <i class="bi bi-shop" style="font-size: 2rem;"></i>
            <h4 class="fw-bold">Crear Cuenta</h4>
            <p class="text-muted">Regístrate para acceder a la tienda virtual</p>
        </div>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre" required placeholder="Juan Pérez">
            </div>
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" required placeholder="tu@ejemplo.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <button class="btn btn-dark w-100">Registrarse</button>
        </form>

        <p class="mt-3 text-center">
            ¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a>
        </p>
    </div>
</body>

</html>