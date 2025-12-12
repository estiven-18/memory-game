<?php
$pagina = "Estadísticas";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];
$usuario_id = $_SESSION['usuario_id'];

require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

if ($rol === 'admin') {


    //* ESTADSUITICAS PARA EL ADMIN



    $sqlJugadores = "SELECT COUNT(*) as total FROM usuarios WHERE rol = 'jugador' OR rol = 'JUGADOR'";
    $stmtJugadores = $pdo->prepare($sqlJugadores);
    $stmtJugadores->execute();
    $totalJugadores = $stmtJugadores->fetch(PDO::FETCH_ASSOC)['total'];

    $sqlPartidas = "SELECT COUNT(*) as total FROM partidas";
    $stmtPartidas = $pdo->prepare($sqlPartidas);
    $stmtPartidas->execute();
    $totalPartidas = $stmtPartidas->fetch(PDO::FETCH_ASSOC)['total'];

    $sqlMazos = "SELECT COUNT(*) as total FROM mazos";
    $stmtMazos = $pdo->prepare($sqlMazos);
    $stmtMazos->execute();
    $totalMazos = $stmtMazos->fetch(PDO::FETCH_ASSOC)['total'];

    $sqlPuntos = "SELECT puntaje_total as total FROM usuarios";
    $stmtPuntos = $pdo->prepare($sqlPuntos);
    $stmtPuntos->execute();
    $puntosTotales = $stmtPuntos->fetch(PDO::FETCH_ASSOC)['total'];
} else {
    //* ESTADÍSTICAS PARA EL JUGADOR 
    $sqlPuntos = "SELECT puntaje_total FROM usuarios WHERE id = ?";
    $stmtPuntos = $pdo->prepare($sqlPuntos);
    $stmtPuntos->execute([$usuario_id]);
    $misPuntos = $stmtPuntos->fetch(PDO::FETCH_ASSOC)['puntaje_total'];

    $sqlPartidas = "SELECT COUNT(*) as total FROM partidas WHERE id_jugador = ?";
    $stmtPartidas = $pdo->prepare($sqlPartidas);
    $stmtPartidas->execute([$usuario_id]);
    $misPartidas = $stmtPartidas->fetch(PDO::FETCH_ASSOC)['total'];

    $sqlMejor = "SELECT COALESCE(MAX(puntaje_obtenido), 0) as mejor FROM partidas WHERE id_jugador = ?";
    $stmtMejor = $pdo->prepare($sqlMejor);
    $stmtMejor->execute([$usuario_id]);
    $mejorPuntaje = $stmtMejor->fetch(PDO::FETCH_ASSOC)['mejor'];

    $sqlRanking = "SELECT COUNT(*) + 1 as posicion FROM usuarios WHERE (rol = 'jugador' OR rol = 'JUGADOR') AND puntaje_total > (SELECT puntaje_total FROM usuarios WHERE id = ?)";
    $stmtRanking = $pdo->prepare($sqlRanking);
    $stmtRanking->execute([$usuario_id]);
    $posicionClasificacion = $stmtRanking->fetch(PDO::FETCH_ASSOC)['posicion'];
}


$sqlTop10 = "SELECT id, nombre, puntaje_total FROM usuarios WHERE rol = 'jugador' OR rol = 'JUGADOR'ORDER BY puntaje_total DESC LIMIT 10";
$stmtTop10 = $pdo->prepare($sqlTop10);
$stmtTop10->execute();
$clasificacion = $stmtTop10->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/estadisticas.css">

<div class="container stats-container">
    <div class="text-center mt-4 mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color: #333;">
            Estadísticas
        </h1>
    </div>

    <div class="row g-4">
        <?php if ($rol === 'admin'): ?>
            <!-- //*  Vista Admin -->
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon green">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $totalJugadores; ?></p>
                            <p class="stat-label">Jugadores</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $totalPartidas; ?></p>
                            <p class="stat-label">Partidas Jugadas</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon orange">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $totalMazos; ?></p>
                            <p class="stat-label">Mazos Disponibles</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon gold">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $puntosTotales; ?></p>
                            <p class="stat-label">Puntos Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>


            <!-- //*  Vista Jugador -->
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon gold">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $misPuntos; ?></p>
                            <p class="stat-label">Mis Puntos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $misPartidas; ?></p>
                            <p class="stat-label">Partidas Jugadas</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon orange">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <p class="stat-value"><?php echo $mejorPuntaje; ?></p>
                            <p class="stat-label">Mejor Puntaje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon purple">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <p class="stat-value">#<?php echo $posicionClasificacion; ?></p>
                            <p class="stat-label">Posición en Clasificación</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- /* TOOP 10 TABLA DE CLASIFICACIÓN -->


    <div class="ranking-card mt-4">
        <div class="ranking-header">
            <h3 class="mb-0"><i class="fas fa-trophy me-2"></i>Top 10 Jugadores</h3>
        </div>
        <div class="ranking-list">
            <?php if (count($clasificacion) === 0): ?>
                <p class="text-center text-muted">No hay jugadores registrados</p>
            <?php else: ?>

                <?php foreach ($clasificacion as $i => $jugador):
                    $posicion = $i + 1;
                    $claseEstilo = 'normal';
                    $insignia = '';

                    if ($posicion === 1) {
                        $claseEstilo = 'gold';
                    } elseif ($posicion === 2) {
                        $claseEstilo = 'silver';
                    } elseif ($posicion === 3) {
                        $claseEstilo = 'bronze';
                    }

                    $esUsuarioActual = ($rol !== 'admin' && $jugador['id'] == $usuario_id);
                    $claseResaltado = $esUsuarioActual ? 'user-highlight' : '';
                ?>
                    <div class="ranking-item <?php echo $claseResaltado; ?>">
                        <div class="ranking-position <?php echo $claseEstilo; ?>">
                            <?php echo $posicion; ?>
                        </div>



                        
                        <div class="ranking-info">
                            <p class="ranking-name">
                                <?php echo htmlspecialchars($jugador['nombre']); ?>
                            </p>
                            <p class="ranking-points">
                                <?php echo $jugador['puntaje_total']; ?> puntos
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>