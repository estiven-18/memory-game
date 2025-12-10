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

// Validar que el mazo tenga suficientes cartas para la dificultad seleccionada
require_once '../model/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

$sql = "SELECT COUNT(*) as total FROM cartas WHERE id_mazo = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_mazo]);
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$totalCartas = $resultado['total'];

$mysql->desconectar();

// Validar según dificultad
$cartasNecesarias = 0;
switch ($dificultad) {
    case 'facil':
        $cartasNecesarias = 5;
        break;
    case 'medio':
        $cartasNecesarias = 8;
        break;
    case 'dificil':
        $cartasNecesarias = 12;
        break;
}

if ($totalCartas < $cartasNecesarias) {
    $_SESSION['error_message'] = "Este mazo no tiene suficientes cartas para el nivel $dificultad. Se necesitan al menos $cartasNecesarias cartas.";
    header('location: seleccionar_dificultad.php?deck_id=' . $id_mazo);
    exit();
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/jugar.css">

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
