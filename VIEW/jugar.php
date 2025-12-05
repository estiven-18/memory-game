<?php
$pagina = "Jugar";

session_start();

//*verificar que el usuario este logueado
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

//* Obtener el ID del mazo desde la URL
$id_mazo = $_GET['id_mazo'];
$dificultad = isset($_GET['dificultad']) ? $_GET['dificultad'] : 'facil';

//* si no hay mazo en la url redirigir al inicio
if (!$id_mazo) {
    header('location: ./index.php');
    exit();
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<style>
    /* Estilos del juego */
    .game-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
    }

    /* Panel de información */
    .info-panel {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stats {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 32px;
        font-weight: bold;
        color: #4a90e2;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }

    /* Tablero del juego */
    .game-board {
        display: grid;
        gap: 15px;
        margin: 30px auto;
        max-width: 600px;
    }

    /* Diferentes tamaños según dificultad */
    .game-board.facil {
        grid-template-columns: repeat(4, 1fr);
    }

    .game-board.medio {
        grid-template-columns: repeat(4, 1fr);
    }

    .game-board.dificil {
        grid-template-columns: repeat(6, 1fr);
    }

    /* Carta */
    .card {
        aspect-ratio: 1;
        position: relative;
        cursor: pointer;
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }

    .card.flipped {
        transform: rotateY(180deg);
    }

    .card.matched {
        opacity: 0.6;
        cursor: default;
        transform: rotateY(180deg) !important;
    }

    /* Ocultar el reverso cuando la carta está emparejada */
    .card.matched .card-back {
        display: none;
    }

    /* Asegurar que el frente se muestre correctamente cuando está emparejada */
    .card.matched .card-front {
        transform: rotateY(0deg) !important;
    }

    /* Frente y atrás de la carta */
    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .card-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 40px;
    }

    .card-front {
        background: white;
        transform: rotateY(180deg);
    }

    .card-front img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    /* Botones */
    .game-buttons {
        text-align: center;
        margin-top: 30px;
    }

    .btn-game {
        padding: 12px 30px;
        margin: 5px;
        font-size: 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-restart {
        background: #4a90e2;
        color: white;
    }

    .btn-restart:hover {
        background: #357abd;
    }

    .btn-exit {
        background: #e74c3c;
        color: white;
    }

    .btn-exit:hover {
        background: #c0392b;
    }

    /* Modal de fin de juego */
    .game-over-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .game-over-content {
        background: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        max-width: 400px;
    }

    .game-over-content h2 {
        color: #4a90e2;
        margin-bottom: 20px;
    }

    .game-over-content .final-score {
        font-size: 48px;
        font-weight: bold;
        color: #2ecc71;
        margin: 20px 0;
    }
</style>

<div class="game-container">
    <!-- Panel de información -->
    <div class="info-panel">
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value" id="puntos">0</div>
                <div class="stat-label">Puntos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="movimientos">0</div>
                <div class="stat-label">Movimientos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="parejas">0</div>
                <div class="stat-label">Parejas</div>
            </div>
        </div>
    </div>

    <!-- Tablero del juego -->
    <div id="gameBoard" class="game-board <?php echo $dificultad; ?>">
    </div>

    <div class="game-buttons">
        <button class="btn-game btn-restart" onclick="reiniciarJuego()">
            Reiniciar Juego
        </button>
        <button class="btn-game btn-exit" onclick="volverInicio()">
            Volver al Inicio
        </button>
    </div>
</div>

<div id="gameOverModal" class="game-over-modal">
    <div class="game-over-content">
        <h2>¡Juego Terminado!</h2>
        <p>Has completado el juego</p>
        <div class="final-score" id="finalScore">0</div>
        <p>puntos obtenidos</p>
        <div style="margin-top: 20px;">
            <button class="btn-game btn-restart" onclick="reiniciarJuego()">Jugar de Nuevo</button>
            <button class="btn-game btn-exit" onclick="volverInicio()">Volver al Inicio</button>
        </div>
    </div>
</div>


<!--/? debe ir antes del script porque sino no funicona -->
<script>
    //? Pasar datos de PHP a JavaScript
    const idMazo = <?php echo $id_mazo; ?>;
    const idJugador = <?php echo $_SESSION['usuario_id']; ?>;
    const dificultad = '<?php echo $dificultad; ?>';
</script>
<script src="../ASSETS/js/jugar.js"></script>

<?php require_once './layout/footer.php'; ?>
