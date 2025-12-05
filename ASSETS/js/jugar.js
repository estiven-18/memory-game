//* Variables globales del juego
let cartas = []; //* Array con todas las cartas del mazo
let cartasJuego = []; //* Array con las cartas duplicadas para el juego
let primeraCarta = null; //* Primera carta seleccionada
let segundaCarta = null; //* Segunda carta seleccionada
let bloqueado = false; //* Bloquear clicks mientras se comparan cartas
//* Estadísticas del juego
let puntos = 0;
let movimientos = 0;
let parejasEncontradas = 0;
let totalParejas = 0;

//* Cuando carga la página, iniciar el juego
document.addEventListener('DOMContentLoaded', function() {
    cargarCartasDelMazo();
});

//* Función para cargar las cartas desde el servidor
function cargarCartasDelMazo() {
    //* Hacer petición al servidor para obtener las cartas del mazo
    fetch(`../CONTROLLER/obtenerMazo.php?id=${idMazo}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartas = data.cartas;
                iniciarJuego();
            } else {
                alert('Error al cargar las cartas');
                window.location.href = './index.php';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar las cartas');
        });
}


//! eliminar 
//* Función para iniciar el juego
function iniciarJuego() {
    //* Reiniciar estadísticas
    puntos = 0;
    movimientos = 0;
    parejasEncontradas = 0;
    
    //* Actualizar interfaz
    actualizarEstadisticas();
    
    //* Preparar cartas según dificultad
    prepararCartas();
    
    //* Crear el tablero
    crearTablero();
}

//* Función para preparar las cartas según la dificultad
function prepararCartas() {
    let cantidadParejas;
    
    //* Definir cantidad de parejas según dificultad
    if (dificultad === 'facil') {
        cantidadParejas = 8; // 4x4 = 16 cartas (8 parejas)
    } else if (dificultad === 'medio') {
        cantidadParejas = 8; // 4x4 = 16 cartas (8 parejas)
    } else { // dificil
        cantidadParejas = 18; // 6x6 = 36 cartas (18 parejas)
    }
    
    //* Tomar solo las cartas necesarias
    let cartasSeleccionadas = cartas.slice(0, cantidadParejas);
    
    //* Duplicar las cartas para crear las parejas
    cartasJuego = [];
    cartasSeleccionadas.forEach(carta => {
        //* Agregar la carta dos veces (pareja)
        cartasJuego.push({...carta, id: carta.id + '_a'});
        cartasJuego.push({...carta, id: carta.id + '_b'});
    });
    
    //* Mezclar las cartas aleatoriamente
    cartasJuego = mezclarArray(cartasJuego);
    
    //* Establecer total de parejas
    totalParejas = cantidadParejas;
}

//* Función para mezclar un array (algoritmo Fisher-Yates)
function mezclarArray(array) {
    let nuevoArray = [...array];
    for (let i = nuevoArray.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [nuevoArray[i], nuevoArray[j]] = [nuevoArray[j], nuevoArray[i]];
    }
    return nuevoArray;
}

//* Función para crear el tablero con las cartas
function crearTablero() {
    const tablero = document.getElementById('gameBoard');
    tablero.innerHTML = ''; 
    
    //* Crear cada carta
    cartasJuego.forEach((carta, index) => {
        const cartaElemento = document.createElement('div');
        cartaElemento.classList.add('card');
        cartaElemento.dataset.index = index;
        cartaElemento.dataset.nombre = carta.nombre;
        
        //* Parte de atrás de la carta (oculta la imagen)
        const cartaAtras = document.createElement('div');
        cartaAtras.classList.add('card-back');
        cartaAtras.innerHTML = '?';
        
        //* Parte de frente de la carta (muestra la imagen)
        const cartaFrente = document.createElement('div');
        cartaFrente.classList.add('card-front');
        const imagen = document.createElement('img');
        //* Ajustar la ruta de la imagen (subir un nivel desde VIEW/)
        imagen.src = '../' + carta.imagen_frente;
        imagen.alt = carta.nombre;
        cartaFrente.appendChild(imagen);
        
        //* Agregar ambas caras a la carta
        cartaElemento.appendChild(cartaAtras);
        cartaElemento.appendChild(cartaFrente);
        
        //* Evento click para voltear la carta
        cartaElemento.addEventListener('click', () => voltearCarta(cartaElemento, index));
        
        //* Agregar carta al tablero
        tablero.appendChild(cartaElemento);
    });
}

//* funcion para voltear una carta
function voltearCarta(cartaElemento, index) {
    // No hacer nada si el juego está bloqueado
    if (bloqueado) return;
    
    //* No hacer nada si la carta ya está volteada
    if (cartaElemento.classList.contains('flipped')) return;
    
    //* No hacer nada si la carta ya fue emparejada
    if (cartaElemento.classList.contains('matched')) return;
    
    //* Voltear la carta
    cartaElemento.classList.add('flipped');
    
    //* Verificar si es la primera o segunda carta   
    if (!primeraCarta) {
        //* Es la primera carta
        primeraCarta = {
            elemento: cartaElemento,
            index: index,
            nombre: cartasJuego[index].nombre
        };
    } else {
        //* Es la segunda carta
        segundaCarta = {
            elemento: cartaElemento,
            index: index,
            nombre: cartasJuego[index].nombre
        };
        
        //* Incrementar movimientos
        movimientos++;
        actualizarEstadisticas();
        
        //* Bloquear más clicks
        bloqueado = true;
        
        //* Comparar las dos cartas después de un momento
        setTimeout(compararCartas, 1000);
    }
}

//* funcion para comparar las dos cartas seleccionadas
function compararCartas() {
    // Verificar si las cartas son iguales
    if (primeraCarta.nombre === segundaCarta.nombre) {
        //* ¡Pareja encontrada!
        //* Mantener la clase flipped para que se queden mostrando la imagen
        primeraCarta.elemento.classList.add('matched');
        segundaCarta.elemento.classList.add('matched');
        
        //* Sumar puntos (+20 por acierto)
        puntos += 20;
        
        //* Incrementar parejas encontradas
        parejasEncontradas++;
        
        //* Actualizar estadísticas
        actualizarEstadisticas();
        
        //* Verificar si el juego terminó
        if (parejasEncontradas === totalParejas) {
            setTimeout(juegoTerminado, 500);
        }
    } else {
        //* No son pareja, voltear de nuevo
        primeraCarta.elemento.classList.remove('flipped');
        segundaCarta.elemento.classList.remove('flipped');
        
        //* Restar puntos (-5 por fallo)
        puntos -= 5;
        
        //* No permitir puntos negativos
        if (puntos < 0) puntos = 0;
        
        //* Actualizar estadísticas
        actualizarEstadisticas();
    }
    
    //* Reiniciar selección
    primeraCarta = null;
    segundaCarta = null;
    bloqueado = false;
}

//* funcion para actualizar las estadísticas en pantalla
function actualizarEstadisticas() {
    document.getElementById('puntos').textContent = puntos;
    document.getElementById('movimientos').textContent = movimientos;
    document.getElementById('parejas').textContent = parejasEncontradas + ' / ' + totalParejas;
}

//* funcion cuando el juego termina
function juegoTerminado() {
    document.getElementById('finalScore').textContent = puntos;
    
    const modal = document.getElementById('gameOverModal');
    modal.style.display = 'flex';
    
    guardarPartida();
}

//* funcion para guardar la partida en la base de datos
function guardarPartida() {
    //* Preparar datos a enviar
    const datosPartida = {
        id_jugador: idJugador,
        id_mazo: idMazo,
        dificultad: dificultad,
        puntaje_obtenido: puntos,
        movimientos: movimientos
    };
    
    fetch('../CONTROLLER/guardarPartida.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datosPartida)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Partida guardada correctamente');
        } else {
            console.error('Error al guardar partida:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

//* funcion para reiniciar el juego
function reiniciarJuego() {
    // Ocultar modal si está visible
    const modal = document.getElementById('gameOverModal');
    modal.style.display = 'none';
    
    // Reiniciar el juego
    iniciarJuego();
}

// // Función para volver al inicio
// function volverInicio() {
//     window.location.href = './index.php';
// }
