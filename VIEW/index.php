<?php
$pagina = "Inicio";

session_start();

$rol = $_SESSION['rol'];

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="main-container">
    <div class="container">

        <!-- Header -->
        <div class="text-center mt-5 mb-5 fade-in-up" style="color: #333;">
            <h1 class="display-3 fw-bold mb-3">
                Juego de Memoria
            </h1>
        </div>

        <!-- //* LOGOUT -->
        <div class="nav-item">
            <a class="btn btn-danger btnLogout" href="../CONTROLLER/log_out.php">
                <i class="bi bi-door-closed-fill"></i>
                Cerrar Sesión
            </a>
        </div>

        <!-- Grid de mazos -->
        <div id="mazosContainer" class="row g-4">
            <div class="col-12 text-center">
                <div class="spinner-border text-white" role="status">
                    <!--/! eliminarrrrrrrrrrrrrrrrrrr -->
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/listarMazos.js"></script>