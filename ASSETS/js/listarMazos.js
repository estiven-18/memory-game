
$(document).ready(function() {
    cargarMazos();
});


function cargarMazos() {
    $.ajax({
        url: '../CONTROLLER/listarMazos.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                mostrarMazos(response.data);
            } else {
                mostrarError(response.message);
            }
        },
        error: function() {
            mostrarError('Error al cargar los mazos');
        }
    });
}

function mostrarMazos(mazos) {
    const contenedor = $('#mazosContainer');
    
    //* se muiesytra un mensaje si no hay mazos
    if (mazos.length === 0) {
        contenedor.html(`
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 bg-white">
                    <div class="card-body text-center py-5">
                        <h3 class="text-muted mb-3">No tienes mazos todavía</h3>
                        <p class="text-secondary mb-4">Crea tu primer mazo para comenzar a jugar</p>
                        <a href="crear_mazo.php" class="btn btn-lg" style="background: #00A86B; color: white;">
                            Crear Mi Primer Mazo
                        </a>
                    </div>
                </div>
            </div>
        `);
        return;
    }
    
    let html = '';
    mazos.forEach((mazo, indice) => {
        const puedeJugar = mazo.total_cards >= 2;
        
        html += `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card card-deck-item h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold mb-2" style="color: #00A86B;">${mazo.name}</h5>
                        <p class="card-text text-center text-muted small mb-3">
                            ${mazo.description || 'Sin descripción'}
                        </p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <h4 class="mb-0" style="color: #00A86B;">${mazo.total_cards}</h4>
                                    <small class="text-muted">Cartas</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <h4 class="mb-0" style="color: #00A86B;">${mazo.total_cards * 2}</h4>
                                    <small class="text-muted">Piezas</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            ${puedeJugar ? `
                                <a href="seleccionar_dificultad.php?deck_id=${mazo.id}" 
                                   class="btn" style="background: #00A86B; color: white;">
                                    JUGAR
                                </a>
                            ` : ''}
                            ${(typeof rolUsuario !== 'undefined' && (rolUsuario === 'admin' || rolUsuario === 'ADMIN')) ? `
                            <div class="btn-group">
                                <a href="ver_mazo.php?deck_id=${mazo.id}" 
                                   class="btn btn-sm" style="border: 1px solid #00A86B; color: #00A86B;">
                                    Ver
                                </a>
                                <a href="agregar_cartas.php?deck_id=${mazo.id}" 
                                   class="btn btn-outline-secondary btn-sm">
                                    Agregar
                                </a>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    contenedor.html(html);
}
