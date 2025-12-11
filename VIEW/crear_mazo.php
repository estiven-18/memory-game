<?php

//* NO SE PUEDE ENTRAR SI NO ERES ADMIN

$pagina = "Crear Mazo";

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION["rol"] != 'admin') {
    header('location: ./login.php');
}

require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/crear_mazo.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mt-3 mb-3" style="color: #333;">
                Crear Nuevo Mazo
            </h1>
        </div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h4 class="mb-0">Crear Mazo</h4>
                </div>
                <div class="card-body">
                    <form id="formCrearMazo">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Mazo</label>
                            <input type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control"
                                id="description"
                                name="description"
                                rows="4"
                                maxlength="200"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit"
                                id="btnCrearMazo"
                                class="btn btn-success">
                                Crear Mazo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/crearMazo.js"></script>