$(document).ready(function() {
    $('#formEditarMazo').submit(function(e) {
        e.preventDefault();
        editarMazo();
    });
});

function editarMazo() {
    let datos = {
        accion: 'editar_mazo',
        mazo_id: $('#mazo_id').val(),
        nombre: $('#nombre_mazo').val(),
        descripcion: $('#descripcion_mazo').val()
    };
    
    $.ajax({
        url: '../CONTROLLER/editarMazo.php',
        type: 'POST',
        data: datos,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'La información del mazo ha sido actualizada',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'ver_mazo.php?deck_id=' + deckId;
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
                text: 'Error al actualizar el mazo'
            });
        }
    });
}
