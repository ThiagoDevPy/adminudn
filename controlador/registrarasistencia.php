<?php
ob_start();
require "../config/conexion.php";
date_default_timezone_set(ZONA_HORARIA);
session_start();


$fecha = date("Y-m-d");
$hora = date("H:i:s");


$user_id = $_POST['user_id'];
$evento_id = $_POST['evento_id'];


$stmt = $conexion->prepare("SELECT * FROM asistencias WHERE alumno_id = ? AND id_evento= ?");
$stmt->bind_param("ii", $user_id, $evento_id);
$stmt->execute();
$resulta = $stmt->get_result();

if ($resulta->num_rows == 1) {
    $stmt = $conexion->prepare("INSERT INTO asistencias (alumno_id, fecha,hora, tipo, id_evento) VALUES (?, '$fecha', '$hora', 'SALIDA', ?);");
    $stmt->bind_param("ii", $user_id, $evento_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Asistencia Guardada Exitosamente.'];
    } else {
        echo "Error al guardar asistencia: " . $stmt->error;
    }
} elseif ($resulta->num_rows >= 2) {
    $response = ['success' => true, 'message' => 'Has registrado la salida y entrada.'];
} elseif ($resulta->num_rows == 0) {
    // Aquí va la lógica para guardar los datos

    $stmt = $conexion->prepare("INSERT INTO asistencias (alumno_id, fecha,hora, tipo, id_evento) VALUES (?, '$fecha', '$hora', 'ENTRADA', ?);");
    $stmt->bind_param("ii", $user_id, $evento_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Asistencia Guardada Exitosamente.'];
    } else {
        echo "Error al guardar asistencia: " . $stmt->error;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();

$conexion->close();


ob_end_flush();
