<?php
$pagina = "Administradores";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION['rol'] !== 'admin') {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];


require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

$sql = "SELECT id, nombre, correo FROM usuarios WHERE rol = 'admin' ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="../ASSETS/css/administradores.css">

<div class="administradores-container">
    <div class="container">



       <div class="text-center mt-4 mb-5">
            <h1 class="display-4 fw-bold mb-3" style="color: #333;">
                Gestionar los Administradores
            </h1>
        </div>

        <div class="card-datatable">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="text-success fw-bold"><i class="fas fa-user-shield me-2"></i>Administradores Registrados</h5>
                <a href="crear_administrador.php" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>Nuevo Administrador
                </a>
            </div>

            <div class="table-responsive">
                <table id="tablaAdministradores" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($administradores as $admin): ?>
                            <tr>
                                <td><?php echo $admin['id']; ?></td>
                                <td><?php echo htmlspecialchars($admin['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($admin['correo']); ?></td>
                                <td>
                                    <a href="editar_administrador.php?id=<?php echo $admin['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                    <button class="btn btn-danger btn-sm btnEliminarAdmin" data-id="<?php echo $admin['id']; ?>">
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
<script src="../ASSETS/js/administradores.js"></script>