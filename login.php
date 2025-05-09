<?php
session_start();
require_once 'db.php';

function verificarPassword($inputPassword, $storedPassword)
{
    list($salt, $storedHash) = explode(':', $storedPassword);
    $inputHash = hash('sha256', $salt . $inputPassword);
    return $inputHash === $storedHash;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM tbl_usuarios WHERE email_usuario = ?");
    $stmt->execute(array($email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && verificarPassword($password, $user['password_usuario'])) {
        $_SESSION['usuario'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
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
            <h4 class="fw-bold">Iniciar Sesión</h4>
            <p class="text-muted">Ingresa tus credenciales para acceder</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" required placeholder="tu@ejemplo.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-dark w-100">Iniciar Sesión</button>
        </form>

        <p class="mt-3 text-center">
            ¿No tienes una cuenta? <a href="registro.php">Regístrate</a>
        </p>
    </div>
</body>

</html>