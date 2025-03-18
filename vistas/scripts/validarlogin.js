function login() {
    // Obtener los valores del formulario
    var usuario = document.getElementById('usuario').value;
    var contrasena = document.getElementById('contrasena').value;
   
    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../controlador/validarlogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   
    // Configurar el callback para manejar la respuesta
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
               var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'escritorio.php'; // Redirigir al dashboard
                } else {
                    bootbox.alert(response);
                }
            } else {
                document.getElementById('message').textContent = 'Error en la solicitud.';
            }
        }
    };
   
    // Enviar los datos del formulario
    xhr.send('usuario=' + encodeURIComponent(usuario) + '&contrasena=' + encodeURIComponent(contrasena));
   }
   
   
   
    $(document).keypress(function (e) {
      if (e.which == 13) { // 13 es el código de la tecla Enter
        e.preventDefault(); // Prevenir el comportamiento por defecto
        login(); // Llamar la función de login
      }
    });
