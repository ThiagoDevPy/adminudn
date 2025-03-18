<?php
// Conexión a la base de datos
include_once "conexion.php";

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener la URL base
$result = $conexion->query("SELECT valor FROM configuracion WHERE clave = 'base_url'");
$configu = $result->fetch_assoc();

$base_url = $configu['valor']; // Ya es la URL completa
?>