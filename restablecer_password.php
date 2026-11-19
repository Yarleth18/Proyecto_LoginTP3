<?php
session_start();
require "conexion.php";

$token = $_GET["token"] ?? $_POST["token"] ?? "";
$tokenHash = hash("sha256", $token);
$error = "";

// Buscar usuario con token válido y no vencido
$stmt = $conexion->prepare(
    "SELECT id FROM usuarios WHERE token_recuperacion = ? AND token_expira > NOW()"
);
$stmt->bind_param("s", $tokenHash);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($usuario && $_SERVER["REQUEST_METHOD"] === "POST") {
    $password  = $_POST["password"] ?? "";
    $password2 = $_POST["password2"] ?? "";

    if ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
        $error = "Mín 8 caracteres, mayúscula, minúscula, número y símbolo.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conexion->prepare(
            "UPDATE usuarios
             SET password = ?, token_recuperacion = NULL, token_expira = NULL
             WHERE id = ?"
        );
        $stmt->bind_param("si", $hash, $usuario["id"]);
        $stmt->execute();
        $stmt->close();

        $_SESSION["exito"] = "Contraseña actualizada. Ya podés iniciar sesión.";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="tarjeta">
        <h1>Nueva contraseña</h1>

        <?php if (!$usuario): ?>
            <div class="alerta alerta-error">El enlace no es válido o ya venció.</div>
            <div class="enlaces">
                <a href="olvide_password.php">Pedir un nuevo enlace</a>
            </div>
        <?php else: ?>

            <?php if ($error): ?>
                <div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form id="formRestablecer" action="restablecer_password.php" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>
                <small class="error" id="errorPassword"></small>

                <input type="password" id="password2" name="password2" placeholder="Repetir contraseña" required>
                <small class="error" id="errorPassword2"></small>

                <button type="submit">Guardar contraseña</button>
            </form>

        <?php endif; ?>

        <div class="enlaces">
            <a href="index.php">Volver a iniciar sesión</a>
        </div>
    </main>

    <script src="js/validaciones.js"></script>
</body>
</html>