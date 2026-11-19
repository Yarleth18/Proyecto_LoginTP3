<?php
session_start();
require "conexion.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo    = trim($_POST["correo"] ?? "");
    $apellido  = trim($_POST["apellido"] ?? "");
    $password  = $_POST["password"] ?? "";
    $password2 = $_POST["password2"] ?? "";

    if ($correo === "" || $apellido === "" || $password === "") {
        $error = "Completá todos los campos.";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $correo)) {
        $error = "Ingresá un correo @gmail.com válido.";
    } elseif ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
        $error = "La contraseña debe tener mín. 8 caracteres, mayúscula, minúscula, número y símbolo.";
    } else {
        // Verificar que correo y apellido coincidan con un usuario registrado
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ? AND apellido = ?");
        $stmt->bind_param("ss", $correo, $apellido);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($usuario) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hash, $usuario["id"]);
            $stmt->execute();
            $stmt->close();

            $_SESSION["exito"] = "Contraseña actualizada. Ya podés iniciar sesión.";
            header("Location: index.php");
            exit;
        } else {
            $error = "El correo y el apellido no coinciden con ningún usuario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="tarjeta">
        <h1>Recuperar contraseña</h1>
        <p class="texto">Confirmá tu correo y apellido, y elegí una nueva contraseña.</p>

        <?php if ($error): ?>
            <div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="formOlvide" action="olvide_password.php" method="POST">
            <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
            <small class="error" id="errorCorreo"></small>

            <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
            <small class="error" id="errorApellido"></small>

            <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>
            <small class="error" id="errorPassword"></small>

            <input type="password" id="password2" name="password2" placeholder="Repetir contraseña" required>
            <small class="error" id="errorPassword2"></small>

            <button type="submit">Cambiar contraseña</button>
        </form>

        <div class="enlaces">
            <a href="index.php">Volver a iniciar sesión</a>
        </div>
    </main>

    <script src="js/validaciones.js"></script>
</body>
</html>