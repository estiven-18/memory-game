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


$sqlTop10 = "SELECT id, nombre, puntaje_total, numero_ficha FROM usuarios WHERE rol = 'jugador' OR rol = 'JUGADOR'ORDER BY puntaje_total DESC LIMIT 10";
$stmtTop10 = $pdo->prepare($sqlTop10);
$stmtTop10->execute();
$clasificacion = $stmtTop10->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los estudiantes para la tabla completa
$sqlTodos = "SELECT nombre, numero_ficha, puntaje_total FROM usuarios WHERE rol = 'jugador' OR rol = 'JUGADOR' ORDER BY puntaje_total DESC";
$stmtTodos = $pdo->prepare($sqlTodos);
$stmtTodos->execute();
$todosEstudiantes = $stmtTodos->fetchAll(PDO::FETCH_ASSOC);

// Obtener partidas según el rol
if ($rol === 'admin') {
    // Admin ve todas las partidas
    $sqlPartidas = "SELECT partidas.*, usuarios.nombre as jugador_nombre, mazos.nombre as mazo_nombre FROM partidas JOIN usuarios  ON partidas.id_jugador = usuarios.id JOIN mazos ON partidas.id_mazo = mazos.id ORDER BY partidas.fecha DESC";
    $stmtPartidasLista = $pdo->prepare($sqlPartidas);
    $stmtPartidasLista->execute();
} else {
    // Jugador solo ve sus partidas
    $sqlPartidas = "SELECT partidas.*, mazos.nombre as mazo_nombre FROM partidas JOIN mazos ON partidas.id_mazo = mazos.id WHERE partidas.id_jugador = ? ORDER BY partidas.fecha DESC";
    $stmtPartidasLista = $pdo->prepare($sqlPartidas);
    $stmtPartidasLista->execute([$usuario_id]);
}
$listaPartidas = $stmtPartidasLista->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/estadisticas.css?v=2">

<div class="container stats-container">
    <div class="text-center mt-4 mb-4">
        <h1 class="display-4 fw-bold mb-3" style="color: #333;">
            Estadísticas
        </h1>


    </div>

    <div class="row g-4">
        <?php if ($rol === 'admin'): ?>
            <!-- //*  Vista Admin -->
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon green bi bi-people-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $totalJugadores; ?></p>
                        <p class="stat-label">Jugadores</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon blue bi bi-trophy-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $totalPartidas; ?></p>
                        <p class="stat-label">Partidas Jugadas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon orange bi bi-layers-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $totalMazos; ?></p>
                        <p class="stat-label">Mazos Disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon gold bi bi-star-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $puntosTotales; ?></p>
                        <p class="stat-label">Puntos Totales</p>
                    </div>
                </div>
            </div>
        <?php else: ?>


            <!-- //*  Vista Jugador -->
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon gold bi bi-star-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $misPuntos; ?></p>
                        <p class="stat-label">Mis Puntos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon blue bi bi-controller"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $misPartidas; ?></p>
                        <p class="stat-label">Partidas Jugadas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon orange bi bi-trophy-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value"><?php echo $mejorPuntaje; ?></p>
                        <p class="stat-label">Mejor Puntaje</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="stat-icon purple bi bi-award-fill"></i>
                    <div class="stat-card-header">
                        <p class="stat-value">#<?php echo $posicionClasificacion; ?></p>
                        <p class="stat-label">Posición en Clasificación</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <div class="quick-nav-buttons">

        <a href="#todosEstudiantes" class="btn-quick-nav">
             Todos los Estudiantes
        </a>
        <a href="#partidas" class="btn-quick-nav">
             Partidas
        </a>
    </div>


    <div id="top10" class="ranking-card mt-4">
        <div class="ranking-header">
            <h3 class="mb-0">Top 10 Jugadores</h3>
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
                                <i class="fas fa-star"></i> <?php echo $jugador['puntaje_total']; ?> puntos
                            </p>
                            <p class="ranking-ficha">
                                Ficha: <?php echo $jugador['numero_ficha']; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="todosEstudiantes" class="ranking-card mt-5">
        <div class="ranking-header">
            <h3 class="mb-0">Todos los Estudiantes</h3>
        </div>
        <div class="p-4">
            <div class="table-responsive">
                <table id="tablaEstudiantes" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Ficha</th>
                            <th>Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosEstudiantes as $i => $estudiante): ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?php echo $estudiante['numero_ficha']; ?></td>
                                <td><strong><?php echo $estudiante['puntaje_total']; ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla de Partidas -->
    <div id="partidas" class="ranking-card mt-5">
        <div class="ranking-header">
            <h3 class="mb-0"><?php echo $rol === 'admin' ? 'Todas las Partidas' : 'Mis Partidas'; ?></h3>
        </div>
        <div class="p-4">
            <div class="table-responsive">
                <table id="tablaPartidas" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php if ($rol === 'admin'): ?>
                                <th>Jugador</th>
                            <?php endif; ?>
                            <th>Mazo</th>
                            <th>Dificultad</th>
                            <th>Puntaje</th>
                            <th>Movimientos</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaPartidas as $i => $partida):
                            $clasesPuntaje = $partida['puntaje_obtenido'] < 0 ? 'puntaje-negativo' : 'puntaje-positivo';
                            $dificultadClase = 'dificultad-' . strtolower($partida['dificultad']);
                        ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <?php if ($rol === 'admin'): ?>
                                    <td><?php echo htmlspecialchars($partida['jugador_nombre']); ?></td>
                                <?php endif; ?>
                                <td><?php echo htmlspecialchars($partida['mazo_nombre']); ?></td>
                                <td>
                                    <span class="badge-dificultad <?php echo $dificultadClase; ?>">
                                        <?php echo ucfirst($partida['dificultad']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-puntaje <?php echo $clasesPuntaje; ?>">
                                        <?php echo $partida['puntaje_obtenido']; ?>
                                    </span>
                                </td>
                                <td><?php echo $partida['movimientos']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($partida['fecha'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#tablaEstudiantes').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true
        });

        $('#tablaPartidas').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
        });
    });
</script>