<?php
session_start();
error_reporting(E_ALL); // Activa la visualización de todos los errores
ini_set('display_errors', 1); // Muestra los errores directamente en el navegador
require '../config/conexion.php';
require 'phpqrcode/qrlib.php';
include_once '../config/qrconfig.php';
if (isset($_GET['id'])) {
    global $base_url; 
    $id = $_SESSION['qr_id'];

    if (empty($id)) {
        echo json_encode(['error' => 'ID no válido.']);
        exit();
    }
    // Verificar en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM qr WHERE qr_id = ? AND estado = 'no utilizado'");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Marcar como utilizado
        $stmt = $conexion->prepare("UPDATE qr SET estado = 'utilizado' WHERE qr_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // Generar un nuevo QR
        $new_id = uniqid();
        $userid = $_SESSION['user_id'];
        $_SESSION['qr_id'] = $new_id;
        $stmt = $conexion->prepare("INSERT INTO qr (qr_id, estado) VALUES (?, 'no utilizado')");
        $stmt->bind_param("s", $new_id);
        $stmt->execute();
        

    
            $new_qr_code_data = $base_url."/controlador/guardardatos.php?id=" . $new_id;
             $qr_file_path = 'qrcodes/new_qr.' . $userid . '.png';
   
        QRcode::png($new_qr_code_data, $qr_file_path, QR_ECLEVEL_L, 10);

        echo json_encode(['new_qr' => $qr_file_path, 'new_id' => $new_id]);
        exit();
    } else {
        echo json_encode(['error' => 'ID no válido o ya ha sido utilizado.']);
        exit();
    }


}else {
    echo json_encode(['error' => 'No se proporcionó ID.']);
    exit();
}

?>