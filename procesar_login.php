<?php
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$correo   = trim($_POST["correo"] ?? "");
$password = $_POST["password"] ?? "";

$stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario && password_verify($password, $usuario["password"])) {
    session_regenerate_id(true);
    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["nombre"]     = $usuario["nombre"];
    header("Location: dashboard.php");
} else {
    $_SESSION["error"] = "Correo o contraseña incorrectos.";
    header("Location: index.php");
}

$stmt->close();
$conexion->close();
exit;