<?php
    ob_start();
    session_start(); // Iniciar la sesión

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../vistas/login.php');
        exit();
    }

    require 'fpdf/fpdf.php';
    require '../config/conexion.php';

    $id_evento = isset($_POST['evento']) ? $conexion->real_escape_string($_POST['evento']) : '';

    if($id_evento==''){
        echo "No existe el evento";
        exit;
    }

    $texto = $_POST['texto'];

    if (!empty($_POST['cargahor'])) {
        $cargahor = 'Carga horaria: ' . $conexion->real_escape_string($_POST['cargahor']) . ' horas';
    } else {
        $cargahor = '';
    }

    $numpersonas = isset($_POST['numeroPersonas']) ? $conexion->real_escape_string($_POST['numeroPersonas']) : '';

    if($numpersonas == ''){
        echo "No se seleccionó la cantidad de firmas";
        exit;
    } else {
        switch($numpersonas){
            case 1:
                $nombrePersona1 = $_POST['nomprof1'];
                $cargoPersona1 = $_POST['cargo1'];
                if (isset($_FILES['firma1']) && $_FILES['firma1']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal1 = $_FILES['firma1']['tmp_name'];
                    $nombreOriginal1 = $_FILES['firma1']['name'];
                    $rutaDestino1 = '../files/' . $nombreOriginal1;

                    if (move_uploaded_file($nombreTemporal1, $rutaDestino1)) {
                        $firmaPersona1 = $rutaDestino1;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                break;
            case 2:
                $nombrePersona1 = $_POST['nomprof1'];
                $cargoPersona1 = $_POST['cargo1'];
                $nombrePersona2 = $_POST['nomprof2'];
                $cargoPersona2 = $_POST['cargo2'];
                if (isset($_FILES['firma1']) && $_FILES['firma1']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal1 = $_FILES['firma1']['tmp_name'];
                    $nombreOriginal1 = $_FILES['firma1']['name'];
                    $rutaDestino1 = '../files/' . $nombreOriginal1;

                    if (move_uploaded_file($nombreTemporal1, $rutaDestino1)) {
                        $firmaPersona1 = $rutaDestino1;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                if (isset($_FILES['firma2']) && $_FILES['firma2']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal2 = $_FILES['firma2']['tmp_name'];
                    $nombreOriginal2 = $_FILES['firma2']['name'];
                    $rutaDestino2 = '../files/' . $nombreOriginal2;

                    if (move_uploaded_file($nombreTemporal2, $rutaDestino2)) {
                        $firmaPersona2 = $rutaDestino2;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                break;
            case 3:
                $nombrePersona1 = $_POST['nomprof1'];
                $cargoPersona1 = $_POST['cargo1'];
                $nombrePersona2 = $_POST['nomprof2'];
                $cargoPersona2 = $_POST['cargo2'];
                $nombrePersona3 = $_POST['nomprof3'];
                $cargoPersona3 = $_POST['cargo3'];
                if (isset($_FILES['firma1']) && $_FILES['firma1']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal1 = $_FILES['firma1']['tmp_name'];
                    $nombreOriginal1 = $_FILES['firma1']['name'];
                    $rutaDestino1 = '../files/' . $nombreOriginal1;

                    if (move_uploaded_file($nombreTemporal1, $rutaDestino1)) {
                        $firmaPersona1 = $rutaDestino1;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                if (isset($_FILES['firma2']) && $_FILES['firma2']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal2 = $_FILES['firma2']['tmp_name'];
                    $nombreOriginal2 = $_FILES['firma2']['name'];
                    $rutaDestino2 = '../files/' . $nombreOriginal2;

                    if (move_uploaded_file($nombreTemporal2, $rutaDestino2)) {
                        $firmaPersona2 = $rutaDestino2;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                if (isset($_FILES['firma3']) && $_FILES['firma3']['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal3 = $_FILES['firma3']['tmp_name'];
                    $nombreOriginal3 = $_FILES['firma3']['name'];
                    $rutaDestino3 = '../files/' . $nombreOriginal3;

                    if (move_uploaded_file($nombreTemporal3, $rutaDestino3)) {
                        $firmaPersona3 = $rutaDestino3;
                    } else {
                        echo "Error al mover el archivo.";
                    }
                } else {
                    echo "No se ha subido ninguna imagen o hubo un error en la subida.";
                }
                break;
        }
    }

    // Consulta para obtener los datos de los estudiantes
    $sql = "SELECT al.nombres, al.apellidos FROM asistencias as asistencia
            INNER JOIN alumnos as al ON asistencia.alumno_id = al.id
            WHERE asistencia.tipo = 'SALIDA' AND asistencia.id_evento = $id_evento";
    
    // Ejecuta la consulta
    $resultado = $conexion->query($sql);

    // Verifica si la consulta se ejecutó correctamente
    if ($resultado) {
        // Carga todas las filas en un array
        $listado = [];
        while ($fila = $resultado->fetch_object()) {
            $listado[] = $fila;
        }

        // Verificar y mover la imagen de fondo
             // Verificar y mover la imagen de fondo
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si el archivo fue cargado
    if (isset($_FILES['fondo']) && $_FILES['fondo']['error'] == 0) {
        // Obtener la ruta temporal y el nombre del archivo
        $nombreTemporalFondo = $_FILES['fondo']['tmp_name'];
        $nombreArchivoFondo = $_FILES['fondo']['name'];
        $extensionFondo = pathinfo($nombreArchivoFondo, PATHINFO_EXTENSION);
        
        // Definir la ruta donde se almacenará la imagen
        $rutaDestinoFondo = "../files/fondocertificado/" . uniqid() . '.' . $extensionFondo; // Usamos uniqid para asegurar que el no mbre sea único
        
        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($nombreTemporalFondo, $rutaDestinoFondo)) {
        
            // Ahora la imagen se puede usar en el PDF, por ejemplo:
            $fondoCertificado = $rutaDestinoFondo;
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
        echo "Error en la carga del archivo o no se ha seleccionado archivo.";
    }
}





        // Creación del objeto de la clase heredada FPDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 1); // Establece un margen inferior de 1 unidad

        // Genera el PDF para cada persona
        foreach ($listado as $lista) {
                $nom=$lista->nombres . " " . $lista->apellidos;

            $pdf->AddPage();//añade l apagina / en blanco

            $pdf->Image($fondoCertificado, 0, 0, 297, 210); 

            //nombre del participante
            $pdf->SetXY(46,109);
            $pdf->SetFont('Times','B',25);
            //$pdf->SetFillColor(255,255,0);
            $pdf->Cell(205,1,mb_convert_encoding($nom, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);
            $pdf->SetDrawColor(46,46,46);
            $pdf->Line(26,115,271,115);

            //texto del certificado
            $pdf->SetXY(0,119);
            $pdf->SetFont('Helvetica', '', 16);
            $pdf->SetLeftMargin(25);
            $pdf->SetRightMargin(24);
            $pdf->Write(6, mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'));
            $pdf->Ln(7);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Write(10, mb_convert_encoding($cargahor, 'ISO-8859-1', 'UTF-8'));
            // Agregar firmas según el número de personas
            switch($numpersonas){
                 case 1:
                    //primera persona
                    //firma
                    $pdf->Image($firmaPersona1,126,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(111,186,181,186);

                    //nombre
                    $pdf->SetXY(140,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(140,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    break;
                case 2:
                    //primera persona
                    //firma
                    $pdf->Image($firmaPersona1,62,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(47,186,117,186);

                    //nombre
                    $pdf->SetXY(76,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(76,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //segunda persona
                    //firma
                    $pdf->Image($firmaPersona2,197,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(182,186,252,186);

                    //nombre
                    $pdf->SetXY(210,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona2, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(210,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona2, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    break;
                case 3:
                    //primera persona
                    //firma
                    $pdf->Image($firmaPersona1,37,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(17,186,87,186);

                    //nombre
                    $pdf->SetXY(46,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(46,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona1, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //segunda persona
                    //firma
                    $pdf->Image($firmaPersona2,131,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(111,186,181,186);

                    //nombre
                    $pdf->SetXY(140,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona2, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(140,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona2, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //tercera persona
                    //firma
                    $pdf->Image($firmaPersona3,229,168,26);

                    //$pdf->SetLineWidth(0.2);
                    $pdf->Line(209,186,279,186);

                    //nombre
                    $pdf->SetXY(237,192);
                    $pdf->SetFont('Arial','B',14);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($nombrePersona3, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    //cargo
                    $pdf->SetXY(237,198);
                    $pdf->SetFont('Arial','',11);
                    //$pdf->SetFillColor(255,255,0);
                    $pdf->Cell(10,1,mb_convert_encoding($cargoPersona3, 'ISO-8859-1', 'UTF-8'),0,0,'C',false);

                    break;
            }

        }
        // Salida del archivo PDF
        $pdf->Output();
    } else {
        echo "Error al obtener los datos de los estudiantes.";
    }
?>
