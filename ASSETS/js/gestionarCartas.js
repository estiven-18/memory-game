$(document).ready(function() {
    $('.btnEliminarCarta').on('click', function() {
        const cartaId = $(this).data('id');
        eliminarCarta(cartaId);
    });
});

function eliminarCarta(cartaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../CONTROLLER/eliminarCarta.php',
                type: 'POST',
                data: { 
                    carta_id: cartaId,
                    deck_id: deckId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminada',
                            text: 'La carta ha sido eliminada exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
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
                        text: 'Error al eliminar la carta'
                    });
                }
            });
        }
    });
}
