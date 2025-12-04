$(document).ready(function() {
    //* Enviar formulario
    $('#registroForm').submit(function(e) {
        e.preventDefault();
        
        let nombre = $('#nombre').val().trim();
        let correo = $('#correo').val().trim();
        let numero_ficha = $('#numero_ficha').val().trim();
        
        
        
        
        $.ajax({
            url: '../CONTROLLER/registro.php',
            type: 'POST',
            data: {
                rol: 'JUGADOR',
                nombre: nombre,
                correo: correo,
                numero_ficha: numero_ficha
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud'
                });
            }
        });
    });
});
