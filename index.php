<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
$exito = $_SESSION['exito'] ?? '';
unset($_SESSION['error'], $_SESSION['exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="tarjeta">
        <h1>Iniciar sesión</h1>

        <?php if ($error): ?>
            <div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alerta alerta-exito"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <form id="formLogin" action="procesar_login.php" method="POST">
            <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
            <small class="error" id="errorCorreo"></small>

            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <small class="error" id="errorPassword"></small>

            <button type="submit">Ingresar</button>
        </form>

        <div class="enlaces">
            <a href="registro.php">¿No tenés cuenta? Crear una</a>
            <a href="olvide_password.php">¿Olvidaste la contraseña?</a>
        </div>
    </main>

    <script src="js/validaciones.js"></script>
</body>
</html>