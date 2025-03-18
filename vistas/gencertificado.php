<?php
ob_start();
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'header.php';



require '../config/conexion.php';

$sql="SELECT * FROM eventos";
$eventos=$conexion->query($sql);

?>

<!--CONTENIDO -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Generar certificados</h1>
          </div>
          <div class="panel-body" id="formularioregistros">
            <form action="../rpt_cert/cert.php" name="formulario" id="formulario" method="POST" enctype="multipart/form-data" target="_blank">
                
               <!-- Campo para subir un fondo personalizado -->
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="fondo">Subir fondo personalizado para el certificado (*):</label>
                    <label for="fondo">
                        <strong>Observación:</strong>
                        <p>
                            El fondo del certificado debe cumplir estrictamente con los siguientes requisitos para garantizar una correcta disposición de los elementos y evitar errores de escritura o diseño:
                        </p>
                        <ul>
                          
                            <li>
                                <strong>Márgenes y distribución:</strong>  
                                Los márgenes y áreas de contenido deben estar correctamente alineados para evitar solapamientos con texto o imágenes. Se debe mantener un diseño limpio y bien estructurado.
                            </li>
                            <li>
                                <strong>Formato de imagen:</strong>
                                <ul>
                                    <li>El fondo debe estar en un formato de imagen compatible, preferentemente <strong>PNG</strong> (por su soporte para transparencia) o <strong>JPG</strong> (por su compresión eficiente).</li>
                                    <li>La resolución mínima recomendada es <strong>300 DPI</strong> (puntos por pulgada) para evitar pérdida de calidad en la impresión o visualización.</li>
                                      <li>
                                <strong>Dimensiones:</strong>  
                                El tamaño de la imagen debe coincidir exactamente con el formato del documento generado, en este caso, <strong>(2573 x 1820)</strong>. Esto asegura que los elementos no queden fuera de los márgenes establecidos.
                            </li>
                                </ul>
                            </li>
                        </ul>
                    </label>

                    <input class="form-control" type="file" name="fondo" id="fondo" accept="image/*" required>
                    <!-- Vista previa del fondo subido -->
                    <div id="previewFondo" style="margin-top: 10px;">
                        <img id="fondoPreview" src="" alt="Vista previa del fondo" style="max-width: 100%; display: none;">
                    </div>
                </div> 
                
                
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-center">
                     <label for="">Seleccione el evento de cual quieres generar certificados(*): </label>
                    <select name="evento" id="evento" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">Seleccionar evento</option>
                        <?php while($row=$eventos->fetch_assoc()){ ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Ingrese un texto para el certificado(*): </label>
                    <textarea class="form-control" name="texto" id="texto" rows="8" cols="100" required></textarea>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Ingrese la carga horaria: </label>
                    <input class="form-control" type="number" name="cargahor" id="cargahor" min="1" value="">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Seleccione la cantidad de firmas(*): </label>
                    <p><strong>Nota:</strong>En caso de varias firmas, las firmas deben ordenarse por jerarquía: 1ra: menor cargo, 2do: intermedio y 3ra: máxima autoridad.</p>
                    <select id="numeroPersonas" name="numeroPersonas" class="form-control selectpicker" required>
                        <option value="1">1 firma</option>
                        <option value="2">2 firmas</option>
                        <option value="3">3 firmas</option>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-12 col-xs-12">
                    
                </div>
                 <div class="form-group col-lg-6 col-md-12 col-xs-12"  id="personas">
                    
                </div>
                
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"> Generar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


    <script>
        // JavaScript para mostrar los campos de nombre, cargo y firma según la cantidad de personas seleccionada
        function mostrarCampos(numPersonas) {
            var personasDiv = document.getElementById('personas');
            
            // Limpiar los campos existentes
            personasDiv.innerHTML = '';

            // Usar un switch para mostrar los campos correspondientes
            switch (numPersonas) {
                case '1':
                    // Mostrar los campos para una persona
                    personasDiv.innerHTML = `
                    <div>
                        <div class="box-header">
                            <h3 class="box-title">Persona 1</h3>
                        </div>
                        <label for="nomprof1">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof1" name="nomprof1" required>
                        
                        <label for="cargo1">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo1" name="cargo1" required>
                        
                        <label for="firma1">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma1" name="firma1" accept="image/*" required>
                        </div>
                    `;
                    break;
                case '2':
                    // Mostrar los campos para dos personas
                    personasDiv.innerHTML = `
                        <div class="box-header">
                            <h3 class="box-title">Persona 1</h3>
                        </div>
                        <label for="nomprof1">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof1" name="nomprof1" required>
                        
                        <label for="cargo1">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo1" name="cargo1" required>
                        
                        <label for="firma1">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma1" name="firma1" accept="image/*" required>
                        <br>
                        

                        <div class="box-header">
                            <h3 class="box-title">Persona 2</h3>
                        </div>
                        <label for="nomprof2">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof2" name="nomprof2" required>
                        
                        <label for="cargo2">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo2" name="cargo2" required>
                        
                        <label for="firma2">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma2" name="firma2" accept="image/*" required>
                        
                    `;
                    break;
                case '3':
                    // Mostrar los campos para tres personas
                    personasDiv.innerHTML = `
                        <div class="box-header">
                            <h3 class="box-title">Persona 1</h3>
                        </div>
                        <label for="nomprof1">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof1" name="nomprof1" required>
                        
                        <label for="cargo1">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo1" name="cargo1" required>
                        
                        <label for="firma1">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma1" name="firma1" accept="image/*" required>
                        <br>
                        

                        <div class="box-header">
                            <h3 class="box-title">Persona 2</h3>
                        </div>
                        <label for="nomprof2">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof2" name="nomprof2" required>
                        
                        <label for="cargo2">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo2" name="cargo2" required>
                        
                        <label for="firma2">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma2" name="firma2" accept="image/*" required>
                        <br>
                        

                        <div class="box-header">
                            <h3 class="box-title">Persona 3</h3>
                        </div>
                        <label for="nomprof3">Ingrese su nombre(*):</label>
                        <input class="form-control" type="text" id="nomprof3" name="nomprof3" required>
                        
                        <label for="cargo3">Ingrese su cargo(*):</label>
                        <input class="form-control" type="text" id="cargo3" name="cargo3" required>
                        
                        <label for="firma3">Ingrese la imagen de su firma(*)</label><br>
                        <input class="form-control filestyle" data-buttonTetxt="Seleccionar imagen" type="file" id="firma3" name="firma3" accept="image/*" required>
                        
                    `;
                    break;
            }
        };

        // Llamar a la función al cargar la página con el valor "1" (para una persona)
        mostrarCampos('1');

        // Añadir un evento al select para cambiar los campos cuando el usuario selecciona un valor diferente
        document.getElementById('numeroPersonas').addEventListener('change', function() {
            mostrarCampos(this.value);
        });
    </script>




<script>
    // Mostrar vista previa del archivo de imagen cargado
    document.getElementById('fondo').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewImage = document.getElementById('fondoPreview');
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
        }
    });
</script>
<?php require 'footer.php'; ?>


<?php
ob_end_flush();
?>
