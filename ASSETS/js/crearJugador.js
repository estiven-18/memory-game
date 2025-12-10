$(document).ready(function() {
    $('#formCrearJugador').submit(function(e) {
        e.preventDefault();
        
        let datos = {
            accion: 'crear',
            nombre: $('#nombre').val(),
            correo: $('#correo').val(),
            numero_ficha: $('#numero_ficha').val(),
        };
        
        $.ajax({
            url: '../CONTROLLER/jugadorController.php',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(respuesta) {
                if (respuesta.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Jugador creado',
                        text: '¡Jugador creado exitosamente!',
                        showConfirmButton: false,
                        timer: 1200
                    }).then(() => {
                        window.location.href = 'jugadores.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message
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
