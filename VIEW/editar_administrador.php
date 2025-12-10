<?php
$pagina = "Editar Administrador";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];

if ($rol !== 'admin') {
    header('location: ./index.php');
    exit();
}

$id_admin = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_admin) {
    header('location: ./administradores.php');
    exit();
}

require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

$sql = "SELECT id, nombre, correo FROM usuarios WHERE id = ? AND rol = 'admin'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_admin]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$mysql->desconectar();

if (!$admin) {
    header('location: ./administradores.php');
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
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Administrador</h4>
                </div>
                <div class="card-body">
                    <form id="formEditarAdmin">
                        <input type="hidden" id="id" value="<?php echo $admin['id']; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($admin['nombre']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" value="<?php echo htmlspecialchars($admin['correo']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                            <input type="password" class="form-control" id="password" placeholder="Nueva contraseña (opcional)">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                Guardar Cambios
                            </button>
                            <a href="administradores.php" class="btn btn-danger">
                                </i>Volver
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
<script src="../ASSETS/js/editarAdministrador.js"></script>