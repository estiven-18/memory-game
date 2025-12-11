<?php
$pagina = "Crear Jugador";

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
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/crear_jugador.css">

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mt-3 mb-3" style="color: #333;">
            Crear Nuevo Jugador
        </h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h4 class="mb-0">Crear Nuevo Jugador</h4>
                </div>
                <div class="card-body">
                    <form id="formCrearJugador">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="numero_ficha" class="form-label">Número de Ficha</label>
                            <input type="text" class="form-control" id="numero_ficha" placeholder="Número de ficha" required>
                        </div>



                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                Crear Jugador
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../ASSETS/js/crearJugador.js"></script>