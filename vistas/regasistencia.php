<?php
ob_start();
session_start(); // Iniciar la sesión
// Mostrar todos los errores
ini_set('display_errors', 1);

// Mostrar errores de nivel E_ALL (todos los errores)
error_reporting(E_ALL);

// Si deseas también registrar los errores en un archivo de log:
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Cambia 'login.html' por el nombre de tu página de inicio de sesión
    exit();
}
require_once '../config/conexion.php';
require_once 'phpqrcode/qrlib.php';
require_once '../config/qrconfig.php';


$userid = $_SESSION['user_id'];
$qr_file_path = 'qrcodes/new_qr.' . $userid . '.png';
if (!isset($_SESSION['qr_id'])) {
    $new_id = uniqid();
    $_SESSION['qr_id'] = $new_id;
    

    // Usar una declaración preparada para evitar inyecciones SQL
    $stmt = $conexion->prepare("INSERT INTO qr (qr_id, estado) VALUES (?, 'no utilizado')");
    $stmt->bind_param("s", $new_id);
    if (!$stmt->execute()) {
        die("Error al insertar el código QR: " . $stmt->error);
    }


    
    // Generar la URL que se va a codificar en el QR
    $new_qr_code_data = $base_url."/controlador/guardardatos.php?id=" . $new_id;

    // Ruta donde se guardará el archivo QR generado
   
    
    // Generar el código QR con los datos
    QRcode::png($new_qr_code_data, $qr_file_path, QR_ECLEVEL_L, 10);
    
    // Ruta del archivo QR generado
    $qr_image_path = $qr_file_path;
    $debe_generar_qr = true;
} else {
    $debe_generar_qr = false;
}
require 'header.php';
?>

<!-- CONTENIDO -->
<div class="content-wrapper">
   <section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">Registrar Asistencias</h1>
                </div>
                <div class="panel-body table-responsive" id="listadoregistros">
                    <h3 class="text-center">Escanear QR</h3>
                    <br> 
                        <div class="text-center">
                         <label class="text-center">(Atencion: Solo se podrá utilizar un usuario por computadora al utilizar la función de Asistencia QR.)</label>
                            <br> 
                            <label class="text-center">(Ejemplo: si una computadora esta mostrando el QR en el usuario admin1 en la otra computadora debera usar el usuario admin2)</label>
                    </div>
                    
                         
                    <div class="text-center">
                        <!-- Imagen del código QR -->
                        <img id="qrCode" src="<?php echo $qr_file_path; ?>" alt="Código QR" />
                    </div>

                    <!-- Botón Actualizar debajo del código QR -->
                    <div class="text-center mt-3">
                        <button id="btnActualizarQR" style="margin:10px">
                               <span class="navbar-toggler-iconn" onclick="actualizar()" ><img class="navbar-toggler-iconn" src="../publico/img/icono-actualizar.png" alt=""></span>
                        </button>
                    </div>

                    <!-- Contenedor para el temporizador -->
                    <div id="timer" class="text-center mt-3"></div>
                </div>
                <div class="panel-body" id="formularioregistros"></div>
            </div>
        </div>
    </div>
</section>

    </section>
    
    
     <script>
                            
    let timerDuration = 119; // 2 minutos en segundos
    let timer; // Variable para almacenar el intervalo del temporizador

    // Función para mostrar y reiniciar el temporizador
    function startTimer(timerDuration) {
        let timerDisplay = document.getElementById('timer');
        let timerValue = timerDuration;

        timer = setInterval(function() {
            let minutes = parseInt(timerValue / 60, 10);
            let seconds = parseInt(timerValue % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            timerDisplay.textContent = "El QR expira en: " + minutes + ":" + seconds;

            if (--timerValue < 0) {
                clearInterval(timer); // Limpiar el temporizador actual
                updateQRCode(); // Actualizar el QR
                timerDisplay.textContent = "El QR ha expirado.";

                // Reiniciar el temporizador después de 3 segundos
                setTimeout(function() {
                    startTimer(timerDuration); // Reiniciar el temporizador
                }, 3000); // Espera 3 segundos antes de reiniciar
            }
        }, 1000);
    }

    // Función para actualizar el QR
    function updateQRCode() {
        const currentQrId = "<?php echo $_SESSION['qr_id']; ?>"; // Asegúrate de que esta variable está correctamente definida
        console.log("ID actual:", currentQrId);

        if (!currentQrId) {
            console.error("El ID del QR no está definido.");
            return;
        }

       $.get('updateqr.php', { id: currentQrId }, function(data) {
    console.log("Respuesta del servidor:", data); // Verificar respuesta
    try {
        const response = JSON.parse(data);
        if (response.new_qr) {
            const qrImage = document.getElementById('qrCode');
            qrImage.src = response.new_qr + '?' + new Date().getTime(); // Añadir timestamp para evitar caché
        } else {
            console.error("No se encontró un nuevo QR.");
        }
    } catch (error) {
        console.error("Error al parsear la respuesta JSON:", error);
    }
}).fail(function(xhr, status, error) {
    console.error('Error al actualizar el QR:', error);
    console.log('Detalles del error:', xhr.responseText); // Mostrar detalles del error
});
    }

    // Iniciar el temporizador al cargar la página
    window.onload = function() {
        startTimer(timerDuration);
        generarQr();
    };

    // Generar y mostrar el QR al cargar la página
    function generarQr() {
        const qrImagePath = "<?php echo $qr_file_path; ?>";
        const qrImage = document.getElementById('qrCode');
        qrImage.src = qrImagePath + '?' + new Date().getTime(); // Agregar timestamp para evitar caché
    }

    // Función para actualizar el QR y reiniciar el temporizador
    function actualizar() {
         let timerDisplay = document.getElementById('timer');
          let timerValue = timerDuration;
        clearInterval(timer); // Detener el temporizador actual
        updateQRCode(); // Actualizar el QR

        startTimer(timerDuration);
    
        
    }
</script>

                
</div>
<?php require 'footer.php'; ?>

<?php
ob_end_flush();
?>