$(document).ready(function() {
    $('#formEditarAdmin').submit(function(e) {
        e.preventDefault();
        
        let datos = {
            accion: 'editar',
            id: $('#id').val(),
            nombre: $('#nombre').val(),
            correo: $('#correo').val(),
            password: $('#password').val()
        };
        
        $.ajax({
            url: '../CONTROLLER/administradorController.php',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(respuesta) {
                if (respuesta.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Administrador actualizado',
                        text: '¡Administrador actualizado exitosamente!',
                        showConfirmButton: false,
                        timer: 1200
                    }).then(() => {
                        window.location.href = 'administradores.php';
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
