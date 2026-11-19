<?php
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registro.php");
    exit;
}

$nombre    = trim($_POST["nombre"] ?? "");
$apellido  = trim($_POST["apellido"] ?? "");
$correo    = trim($_POST["correo"] ?? "");
$password  = $_POST["password"] ?? "";
$password2 = $_POST["password2"] ?? "";

// Validaciones en el servidor (por si se saltean el JavaScript)
if ($nombre === "" || $apellido === "" || $correo === "" || $password === "") {
    $_SESSION["error"] = "Completá todos los campos.";
    header("Location: registro.php");
    exit;
}
if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $correo)) {
    $_SESSION["error"] = "El correo debe ser @gmail.com.";
    header("Location: registro.php");
    exit;
}
if ($password !== $password2) {
    $_SESSION["error"] = "Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit;
}
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
    $_SESSION["error"] = "La contraseña debe tener mín. 8 caracteres, mayúscula, minúscula, número y símbolo.";
    header("Location: registro.php");
    exit;
}

// ¿Ya existe el correo?
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION["error"] = "Ese correo ya está registrado.";
    $stmt->close();
    header("Location: registro.php");
    exit;
}
$stmt->close();

// INSERT con la contraseña encriptada
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conexion->prepare(
    "INSERT INTO usuarios (nombre, apellido, correo, password) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $nombre, $apellido, $correo, $hash);

if ($stmt->execute()) {
    $_SESSION["exito"] = "Cuenta creada correctamente. Ya podés iniciar sesión.";
    header("Location: index.php");
} else {
    $_SESSION["error"] = "No se pudo crear la cuenta. Intentá de nuevo.";
    header("Location: registro.php");
}
$stmt->close();
$conexion->close();
exit;