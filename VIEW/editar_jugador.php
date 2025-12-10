<?php
$pagina = "Editar Jugador";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null ) {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];

if ($rol !== 'admin') {
    header('location: ./index.php');
    exit();
}

$id_jugador = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_jugador) {
    header('location: ./jugadores.php');
    exit();
}

require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

$sql = "SELECT id, nombre, correo, numero_ficha FROM usuarios WHERE id = ? AND rol = 'jugador'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_jugador]);
$jugador = $stmt->fetch(PDO::FETCH_ASSOC);

$mysql->desconectar();

if (!$jugador) {
    header('location: ./jugadores.php');
    exit();
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Jugador</h4>
                </div>
                <div class="card-body">
                    <form id="formEditarJugador">
                        <input type="hidden" id="id" value="<?php echo $jugador['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($jugador['nombre']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" value="<?php echo htmlspecialchars($jugador['correo']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="numero_ficha" class="form-label">Número de Ficha</label>
                            <input type="text" class="form-control" id="numero_ficha" value="<?php echo htmlspecialchars($jugador['numero_ficha']); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="jugadores.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../ASSETS/js/editarJugadores.js"></script>
