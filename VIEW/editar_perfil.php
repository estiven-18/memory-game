<?php
$pagina = "Editar Perfil";

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
    exit();
}

$rol = $_SESSION['rol'];
$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$numero_ficha = $_SESSION['numero_ficha'];

?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/editar_perfil.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Mi Perfil</h4>
                </div>
                <div class="card-body">
                    <form id="formEditarPerfil">
                        <input type="hidden" id="usuario_id" value="<?php echo $usuario_id; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="index.php" class="btn btn-secondary">
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
<script src="../ASSETS/js/editarPerfil.js"></script>
