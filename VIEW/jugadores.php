<?php
$pagina = "Jugadores";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null && $_SESSION['rol'] !== 'admin') {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];

require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

$sql = "SELECT id, nombre, correo, numero_ficha, puntaje_total FROM usuarios WHERE rol = 'jugador' ORDER BY puntaje_total DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="../ASSETS/css/jugadores.css">

<div class="usuarios-container">
    <div class="container">
        
       

        <div class="mb-3">
            <a class="btn btn-danger" href="../CONTROLLER/log_out.php">
                <i class="fas fa-door-open"></i> Cerrar Sesión
            </a>
        </div>

        <div class="card-datatable">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="text-success fw-bold"><i class="fas fa-users me-2"></i>Jugadores Registrados</h5>
                <a href="crear_jugador.php" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>Nuevo Jugador
                </a>
            </div>
            
            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Número Ficha</th>
                            <th>Puntaje Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jugadores as $jugador): ?>
                            <tr>
                                <td><?php echo $jugador['id']; ?></td>
                                <td><?php echo htmlspecialchars($jugador['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($jugador['correo']); ?></td>
                                <td><?php echo htmlspecialchars($jugador['numero_ficha']);?></td>
                                <td><?php echo $jugador['puntaje_total']; ?></td>
                                <td>
                                    <a href="editar_jugador.php?id=<?php echo $jugador['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                    <button class="btn btn-danger btn-sm btnEliminarJugador" data-id="<?php echo $jugador['id']; ?>">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once './layout/footer.php'; ?>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../ASSETS/js/jugadores.js"></script>
