<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$base = "login_db";

mysqli_report(MYSQLI_REPORT_OFF);

$conexion = new mysqli($host, $usuario, $clave);

if ($conexion->connect_error) {
    die("No se pudo conectar a MySQL. ¿Está encendido en XAMPP? " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

$conexion->query(
    "CREATE DATABASE IF NOT EXISTS `$base`
     CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
);

$conexion->select_db($base);

$conexion->query(
    "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        apellido VARCHAR(50) NOT NULL,
        correo VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);