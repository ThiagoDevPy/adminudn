<?php
ob_start();
// editarproducto.php
include "../config/conexion.php";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
       $valor = $_POST['valor'];
  
    // Validación y actualización de los datos

        // Asume que la actualización se realiza correctamente
        $query = $conexion->prepare("UPDATE configuracion SET valor = ? WHERE clave = 'base_url'");
        $query->bind_param("s", $valor);
        
        if ($query->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se pudo actualizar la url del QR']);
        }
    } 

ob_end_flush();