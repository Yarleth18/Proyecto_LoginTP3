<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="tarjeta">
        <h1>Crear Cuenta</h1>

        <?php if ($error): ?>
            <div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="formRegistro" action="procesar_registro.php" method="POST">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
            <small class="error" id="errorNombre"></small>

            <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
            <small class="error" id="errorApellido"></small>

            <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
            <small class="error" id="errorCorreo"></small>

            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <small class="error" id="errorPassword"></small>

            <input type="password" id="password2" name="password2" placeholder="Repetir contraseña" required>
            <small class="error" id="errorPassword2"></small>

            <button type="submit">Crear Cuenta</button>
        </form>

        <div class="enlaces">
            <a href="index.php">¿Ya tenés cuenta? Iniciar sesión</a>
        </div>
    </main>

    <script src="js/validaciones.js"></script>
</body>
</html>