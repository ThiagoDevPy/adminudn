<?php
ob_start();
session_start(); // Iniciar la sesión



// Conectar a la base de datos
include '../config/conexion.php'; // Asegúrate de que este archivo esté correctamente configurado



// Consultar la base de datos para obtener la información del usuario
$stmt = $conexion->prepare("SELECT valor FROM configuracion WHERE clave ='base_url'");
$stmt->execute();
$result = $stmt->get_result();

// Obtener los datos del usuario
$valor = $result->fetch_assoc();

// Cerrar la consulta y la conexión
$stmt->close();
$conexion->close();

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
if ($valor) {
    echo json_encode([
        'success' => true,
        'valor' => $valor['valor'],
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'valor no encontrado']);
}
ob_end_flush();
?>
