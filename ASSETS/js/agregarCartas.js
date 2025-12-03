
//* se obtine el id del mazo desde un input
const idMazo = $("#deck_id_input").val();

//* cuando el documento se carga la pagina
$(document).ready(function() {
    cargarInfoMazo();
    configurarSeleccionArchivos();
});


function cargarInfoMazo() {
    $.ajax({
        url: '../CONTROLLER/obtenerMazo.php',
        type: 'GET',
        data: { deck_id: idMazo },
        success: function(respuesta) {
            if (respuesta.success) {
                $('#deckName').html('<strong>' + respuesta.deck.name + '</strong> - ' + respuesta.cards.length + ' carta(s)');
            }
        }
    });
}

//* funcion para configurar la seleccion de archivos
//* es decir, cuando el usuario hace click en la zona de drop o selecciona archivos
function configurarSeleccionArchivos() {
    const zona = $('#dropZone');
    const input = $('#card_images');
    
    //*al hacer clic en la zona, abrir selector de archivos
    zona.on('click', function() {
        input.click();
    });
    
    //* manejar arrastrar y soltar archivos
    input.on('change', function() {
        //
        const archivos = this.files;
        if (archivos.length > 0) {
            mostrarArchivosSeleccionados(archivos);
        }
    });
}

//* mostrar archivos seleccionados en la vista previa
function mostrarArchivosSeleccionados(archivos) {
    $('#countNumber').text(archivos.length);
    $('#selectedCount').removeClass('d-none');
    $('#btnSubirCartas').prop('disabled', false);
    
    //* Mostrar preview de las imágenes
    const contenedor = $('#previewContainer');
    contenedor.html('');
    
    for (let i = 0; i < archivos.length; i++) {
        const archivo = archivos[i];
        const lector = new FileReader();
        
        lector.onload = function(e) {
            const html = '<div class="col-6 col-md-4 col-lg-3 mb-3">' +
                        '<div class="card-preview-item">' +
                        '<img src="' + e.target.result + '" class="img-fluid">' +
                        '</div></div>';
            contenedor.append(html);
        };
        
        lector.readAsDataURL(archivo);
    }
}

$('#formSubirCartas').on('submit', function(e) {
    e.preventDefault();
    
    const archivos = $('#card_images')[0].files;
    if (archivos.length === 0) {
        Swal.fire('Error', 'Selecciona al menos una imagen', 'warning');
        return;
    }
    
    const formData = new FormData(this);
    
    $('#btnSubirCartas').prop('disabled', true).text('Subiendo...');
    
    $.ajax({
        url: '../CONTROLLER/subirCartas.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(respuesta) {
            $('#btnSubirCartas').prop('disabled', false).text('Guardar Cartas');
            
            if (respuesta.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta.message,
                    showCancelButton: true,
                    confirmButtonText: 'Agregar Más',
                    cancelButtonText: 'Ver Mazo'
                }).then((resultado) => {
                    if (resultado.isConfirmed) {
                        location.reload();
                    } else {
                        window.location.href = 'ver_mazo.php?deck_id=' + idMazo;
                    }
                });
            } else {
                Swal.fire('Error', respuesta.message, 'error');
            }
        },
        error: function() {
            $('#btnSubirCartas').prop('disabled', false).text('Guardar Cartas');
            Swal.fire('Error', 'No se pudieron subir las cartas', 'error');
        }
    });
});
