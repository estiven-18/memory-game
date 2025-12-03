
$(document).ready(function() {
    //* Enviar formulario con AJAX
    $('#formCrearMazo').on('submit', function(e) {
        e.preventDefault();
        
        
        
        const datosFormulario = $(this).serialize();
        const boton = $('#btnCrearMazo');
        const textoOriginal = boton.html();
        
        // // Deshabilitar botón
        // boton.prop('disabled', true).html('Creando...');
        
        $.ajax({
            url: '../CONTROLLER/crearMazo.php',
            type: 'POST',
            data: datosFormulario,
            dataType: 'json',
            success: function(response) {
                boton.prop('disabled', false).html(textoOriginal);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        showCancelButton: true,
                        confirmButtonColor: '#00A86B',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Agregar Cartas',
                        cancelButtonText: 'Ver Mazos'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `agregar_cartas.php?deck_id=${response.deck_id}`;
                        } else {
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                boton.prop('disabled', false).html(textoOriginal);
                Swal.fire('Error', 'No se pudo crear el mazo', 'error');
            }
        });
    });
});
