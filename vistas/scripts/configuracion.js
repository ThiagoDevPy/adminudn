
//funtion que se ejecuta en el inicio
function init() {

    mostrar();
   
}

function limpiar() {

    $("#links").val("");
}



function cancelarform() {
    limpiar();

}




function guardaryeditar() {
    
   
   bootbox.confirm("¿Esta seguro de actualizar este dato? Deberas actualizar todos los QR que se estan utilizando para que contenga la nueva url.", function (result) {
        if (result) {
            var valor = document.getElementById("link").value.trim();
                
            if (!valor) {
                  bootbox.alert("El campo de la URL no puede estar vacío.");
                     return; // Salir de la función si el valor está vacío
             }
        // Realizar la solicitud AJAX para guardar los cambios
        $.ajax({
            url: '../controlador/Configuracion.php', // Cambia esta URL por la tuya
            type: 'POST',
            data: {
                valor : valor // Usando el nombre correcto de la variable
            },
            dataType: 'json',  // Asegúrate de especificar que esperas un JSON
            success: function(response) {
                if (response.error) {
                    bootbox.alert("Error: " + response.error);  // Si hay un error en la respuesta
                } else {
                    // Limpiar los campos del formulario
                    $('#link').val("");
                    
                    mostrar();
                    bootbox.alert("URL del QR actualizado. (Deberas actualizar todos los QR para que ya contenga la nueva URL)")
                  
                }
            },
            error: function(error) {
                console.error("Error al obtener los datos del QR:", error);
            }
        });
        }
    })
}

function mostrar() {

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../controlador/obtenerconfi.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Mostrar la información del usuario en la página
                   $("#mostrarr").val(response.valor);
                 
                } else {
                    console.log(response.message);
                }
            } else {
                
            }
        }
    };

    xhr.send();
}
 







init();
