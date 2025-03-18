
var tabla;
//funtion que se ejecuta en el inicio
function init() {
    mostrarform(true)


    $.post("../controlador/Asistencia.php?op=select_evento", function (r) {
        $("#id_evento").html(r);
        $('#id_evento').selectpicker('refresh');
    });

}

function mostrarform(flag) {
    if (flag) {
        $("#datos").hide();
        $("#id_evento").show();
        $("#btnlistar").show();
        $('#tbllistado').hide();
    } else {
        $("#datos").show();
        $('#tbllistado').show();
        $('#cedula').prop('disabled', true);
        $('#btnGuardar').prop('disabled', true);
        
    }
}




function cancelar() {
    $("#enombre").val("");
    $("#euniversidad").val("");
    $("#ecorreo").val("");
    $("#etelefono").val("");
    $("#ecarrera").val("");
    $("#ealumno_id").val("");
    $('#cedula').prop('disabled', false);
    $('#btnGuardar').prop('disabled', false);
    mostrarform(true);
}


function buscarci() {
    var cedula = $("#cedula").val();

    $.post("../controlador/Alumno.php?op=buscar", { cedula: cedula },
        function (data, status) {
            // Verificar si la respuesta contiene un error
            data = JSON.parse(data);
            if (data.error) {
                bootbox.alert(data.error);  // Mostrar el mensaje de error
                return;  // Detener la ejecución
            }

            // Si no hay error, procesar los datos
      

            // Verificar si los datos requeridos existen antes de asignarlos
            
                $("#enombre").val(data.nombrecompleto);
                $("#euniversidad").val(data.universidad);
                $("#ecorreo").val(data.correo);
                $("#etelefono").val(data.telefono);
                $("#ecarrera").val(data.carrera);
                $("#ealumno_id").val(data.id);
                mostrarform(false);
            
        });
}






function registrar() {
    // Obtener los valores del formulario
    $('#bntregistrar').prop('disabled', true);
    var evento_id = $("#id_evento").val();
    var user_id = $("#ealumno_id").val();

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../controlador/registrarasistencia.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // Configurar el callback para manejar la respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                bootbox.alert(response.message);
                $('#bntregistrar').prop('disabled', false);
            } else {
                bootbox.alert(response.message);
                $('#bntregistrar').prop('disabled', false);
        }
    } else if (xhr.readyState === 4) {
        bootbox.alert("Error en la solicitud: " + xhr.status);
        $('#bntregistrar').prop('disabled', false);
      }
    };

    // Enviar los datos del formulario
    xhr.send('user_id=' + encodeURIComponent(user_id) + '&evento_id=' + encodeURIComponent(evento_id));
}




function mostrartabla() {
    $("#listadoregistros").show();
}

function ocultartabla() {
    $("#listadoregistros").hide();
}

init();