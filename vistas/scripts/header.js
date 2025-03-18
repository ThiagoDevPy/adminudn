function obtenerInformacionUsuario() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../controlador/obtenerusuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Mostrar la información del usuario en la página
                    document.getElementById('nusuario').textContent = response.username;
                     document.getElementById('userimage').src ="../files/usuarios/"+response.imagen;
                 
                } else {
                    console.log(response.message);
                }
            } else {
                
            }
        }
    };

    xhr.send();
}
 

obtenerInformacionUsuario();