$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#tablaUsuarios').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true
        });
    }
    
    $('.btnEliminarJugador').on('click', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: '¿Eliminar jugador?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../CONTROLLER/jugadorController.php',
                    type: 'POST',
                    data: { accion: 'eliminar', id: id },
                    dataType: 'json',
                    success: function(respuesta) {
                        if (respuesta.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Jugador eliminado',
                                showConfirmButton: false,
                                timer: 1200
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: respuesta.message
                            });
                        }
                    }
                });
            }
        });
    });
});
