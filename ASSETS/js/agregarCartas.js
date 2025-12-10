
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
        const archivos = this.files;
        if (archivos.length > 0) {
            mostrarArchivosSeleccionados(archivos);
        }
    });
    
    //* Eventos de drag and drop
    zona.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('drag-over');
    });
    
    zona.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
    });
    
    zona.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
        
        const archivos = e.originalEvent.dataTransfer.files;
        if (archivos.length > 0) {
            // Actualizar el input con los archivos arrastrados
            input[0].files = archivos;
            mostrarArchivosSeleccionados(archivos);
        }
    });
}

//* Array para almacenar los archivos seleccionados
let archivosSeleccionados = [];

//* mostrar archivos seleccionados en la vista previa
function mostrarArchivosSeleccionados(archivos) {
    // Convertir FileList a Array
    archivosSeleccionados = Array.from(archivos);
    
    actualizarPreview();
}

//* Función para actualizar la previsualización
function actualizarPreview() {
    const contenedor = $('#previewContainer');
    contenedor.html('');
    
    $('#countNumber').text(archivosSeleccionados.length);
    
    if (archivosSeleccionados.length > 0) {
        $('#selectedCount').removeClass('d-none');
        $('#btnSubirCartas').prop('disabled', false);
    } else {
        $('#selectedCount').addClass('d-none');
        $('#btnSubirCartas').prop('disabled', true);
    }
    
    archivosSeleccionados.forEach((archivo, index) => {
        const lector = new FileReader();
        
        lector.onload = function(e) {
            const html = `
                <div class="card-preview-item" data-index="${index}">
                    <img src="${e.target.result}" alt="Carta ${index + 1}">
                </div>
            `;
            contenedor.append(html);
        };
        
        lector.readAsDataURL(archivo);
    });
}

$('#formSubirCartas').on('submit', function(e) {
    e.preventDefault();
    
    if (archivosSeleccionados.length === 0) {
        Swal.fire('Error', 'Selecciona al menos una imagen', 'warning');
        return;
    }
    
    // Crear FormData manualmente con los archivos seleccionados
    const formData = new FormData();
    formData.append('deck_id', $('#deck_id_input').val());
    
    archivosSeleccionados.forEach((archivo, index) => {
        formData.append('card_images[]', archivo);
    });
    
    $('#btnSubirCartas').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Subiendo...');
    
    $.ajax({
        url: '../CONTROLLER/subirCartas.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(respuesta) {
            $('#btnSubirCartas').prop('disabled', false).html('Guardar Cartas');
            
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
            $('#btnSubirCartas').prop('disabled', false).html('Guardar Cartas');
            Swal.fire('Error', 'No se pudieron subir las cartas', 'error');
        }
    });
});
