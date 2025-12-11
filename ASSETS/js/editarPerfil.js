$(document).ready(function() {
    $('#formEditarPerfil').submit(function(e) {
        e.preventDefault();
        
        let datos = {
            accion: 'editar_perfil',
            usuario_id: $('#usuario_id').val(),
            nombre: $('#nombre').val(),
            correo: $('#correo').val()
        };
        
        $.ajax({
            url: '../CONTROLLER/perfilController.php',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function(respuesta) {
                if (respuesta.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Perfil actualizado',
                        text: '¡Tus datos han sido actualizados exitosamente!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'index.php';
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
