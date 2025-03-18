<?php
ob_start();
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
  // Redirigir al usuario a la página de inicio de sesión si no está autenticado
  header('Location: login.php'); // Cambia 'login.html' por el nombre de tu página de inicio de sesión
  exit(); // Asegúrate de salir del script después de redirigir

}

require 'header.php';
?>



<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="row">

            <!-- /.col-md12 -->
            <div class="col-md-12">

                <!--fin box-->
                <div class="box">

                    <!--box-header-->
                    <div class="box-header with-border text-center">

                        <h1 class="box-title">Registro Manual</h1>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <!--box-header-->

                    <!--centro-->

                    <!--tabla para listar datos-->
                    <div class="dataTables_wrapper text-center" style="display: flex; justify-content: center;">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Seleccione un Evento</label>  <br> 
                            <label>(Seleccione el evento en el que desea que el alumno se registre)</label>
                            <select name="id_evento" id="id_evento" class="form-control selectpicker" data-live-search="true" required>
                            </select>


                        </div>


                    </div>



                    <div class="dataTables_wrapper text-center" style="display: flex; justify-content: center; margin: 20px;">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                <label for="">Numero de cedula(*) </label>

                                <input class="form-control" type="number" name="cedula" id="cedula" placeholder="Numero de Cedula" required>
                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" onclick="buscarci()" id="btnGuardar">Buscar</button>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="datos">

                                <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                    <label for="">Nombres</label>

                                    <input class="form-control" type="hidden" name="alumno_id" id="ealumno_id">
                                    <input class="form-control" type="text" name="nombre" id="enombre" placeholder="Nombres"readonly>
                                </div>
                                <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                    <label for="">Teléfono</label>
                                    <input class="form-control" type="number" name="telefono" id="etelefono" placeholder="Teléfono"readonly>
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                    <label for="">Email</label>
                                    <input class="form-control" type="text" name="telecorreofono" id="ecorreo" placeholder="Email"readonly>
                                    
                                </div>
                                <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                    <label for="">Carrera</label>
                                    <input class="form-control" type="text" name="carrera" id="ecarrera" placeholder="Carrera"readonly>
                                </div>
                                <div class="form-group col-lg-12 col-md-6 col-xs-12">
                                    <label for="">Universidad</label>
                                    <input class="form-control" type="text" name="universidad" id="euniversidad" placeholder="Universidad"readonly>
                                </div>


                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-danger" onclick="cancelar()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    <button class="btn btn-primary" onclick="registrar()" id="bntregistrar">Registrar Asistencia</button>
                                </div>


                            </div>


                        </div>
                        <!-- Button trigger modal -->





                    </div>
                    <!--fin tabla para listar datos-->

                    <!--formulatio para datos-->
                    <div class="panel-body" id="formularioregistros">



                    </div>




                    <!--fin formulatio para datos-->

                    <!--fin centro-->

                </div>
                <!--fin box-->

            </div>
            <!-- /.col-md12 -->

        </div>
        <!-- fin Default-box -->

    </section>
    <!-- /.content -->

</div>
<!--FIN CONTENIDO -->
<?php
require 'footer.php';
?>
<script src="scripts/asistenciamanual.js"></script>


<?php
ob_end_flush();
?>