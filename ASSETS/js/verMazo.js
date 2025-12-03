
let datosMazo = null;
const idMazo = new URLSearchParams(window.location.search).get('deck_id');

$(document).ready(function() {
    cargarMazo();
    
    //* evento para eliminar mazo
    $(document).on('click', '.btnEliminarMazo', function() {
        const mazoId = $(this).data('id');
        eliminarMazo(mazoId);
    });
});

//* cargar mazo y sus cartas
function cargarMazo() {
  $.ajax({
    url: "../CONTROLLER/obtenerMazo.php",
    type: "GET",
    data: { deck_id: idMazo },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.success) {
        datosMazo = respuesta;
        mostrarMazo(respuesta.deck, respuesta.cards);
      } else {
        Swal.fire('Error', respuesta.message, 'error');
        setTimeout(() => {
          window.location.href = "index.php";
        }, 2000);
      }
    },
    error: function () {
      Swal.fire('Error', 'No se pudo cargar el mazo', 'error');
      setTimeout(() => {
        window.location.href = "index.php";
      }, 2000);
    },
  });
}

//* mostrar mazo y sus detalles
function mostrarMazo(mazo, cartas) {
  $("#deckName").text(mazo.name);
  $("#deckDescription").text(mazo.description || "Sin descripción");
  $("#totalCards").text(cartas.length);

  if (cartas.length >= 2) {
    $("#btnJugar").removeClass("d-none");
  }

  mostrarCartas(cartas);
}

//* mostrar cartas en el grid
function mostrarCartas(cartas) {
  const contenedor = $("#cardsContainer");

    if (cartas.length === 0) {
        contenedor.html(`
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 bg-white">
                    <div class="card-body text-center py-5">
                        <h4 class="text-muted mb-3">No hay cartas en este mazo</h4>
                        <p class="text-secondary mb-4">Agrega algunas cartas para comenzar a jugar</p>
                        <a href="agregar_cartas.php?deck_id=${idMazo}" class="btn" style="background: #00A86B; color: white;">
                            Agregar Cartas
                        </a>
                    </div>
                </div>
            </div>
        `);
    return;
  }

  let html = "";
  cartas.forEach((carta, indice) => {
    html += `
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card-preview-item">
                    <img src="../${carta.image}" alt="Carta ${
      indice + 1
    }" class="img-fluid">
                </div>
            </div>
        `;
  });

  contenedor.html(html);
}

//* eliminar mazo
function eliminarMazo(mazoId) {
  Swal.fire({
    title: "¿Eliminar mazo?",
    text: "Esta acción no se puede deshacer. Se eliminarán todas las cartas del mazo.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((resultado) => {
    if (resultado.isConfirmed) {
      Swal.fire({
        title: 'Eliminando...',
        html: 'Por favor espera',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: "../CONTROLLER/eliminarMazo.php",
        type: "POST",
        data: { deck_id: mazoId },
        dataType: "json",
        success: function (respuesta) {
          if (respuesta.success) {
            Swal.fire({
              icon: "success",
              title: "¡Eliminado!",
              text: respuesta.message,
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              window.location.href = "index.php";
            });
          } else {
            Swal.fire('Error', respuesta.message, 'error');
          }
        },
        error: function () {
          Swal.fire('Error', 'No se pudo eliminar el mazo', 'error');
        },
      });
    }
  });
}
