<?php
ob_start();
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'header.php';
require "../config/conexion.php";

?>
   <div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Configuracion del QR
                        </h1>
                    </div>

                    <!-- Formulario -->
                    <div class="panel-body" id="formularioregistros">
                        
                              <div class="form-group col-lg-7 col-md-6 col-xs-12">
                                <label>Enlace que se esta utilizando para el QR: </label>
                                <input class="form-control" type="text" name="mostrar" id="mostrarr"readonly>
                            </div>
                            
                            <div class="form-group col-lg-7 col-md-6 col-xs-12">
                                <label>Enlace nuevo para el QR(*): </label><br> 
                            <label>(La url que rellenes debe contener el protocolo y apuntar al dominio que usa la Aplicacion de los Usuarios Ejemplo: "https://DominioDeLaAplicacionDeUsuarios.com")</label>
                                <input class="form-control" type="text" name="link" id="link" placeholder="Enlace del QR">
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>ATENCION: Agregar una URL incorrecta ocasionará errores fatales</label> <br>
                                <button class="btn btn-primary" onclick="guardaryeditar()">
                                    <i class="fa fa-save"></i> Actualizar
                                </button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button" title="Cancelar">
                                    <i class="fa fa-arrow-circle-left"></i> Cancelar
                                </button>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
          
           <?php require 'footer.php'; ?>

          
          
          <script src="scripts/configuracion.js"></script>
          
         


<?php
ob_end_flush();
?>