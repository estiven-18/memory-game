<?php

//* NO SE PUEDE ENTRAR SI NO ERES ADMIN

$pagina = "Ver Mazo";

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION["rol"] != 'admin') {
    header('location: ./login.php');
}

$deck_id = $_GET['deck_id'];


require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="main-container">
    <div class="container">

        <!-- Header del Mazo -->

        <div class="text-center mt-5 mb-5 fade-in-up" style="color: #333;">
            <h1 class="display-3 fw-bold mb-3">
                Ver Mazo
            </h1>
            
        </div>

        <div class="card shadow-sm rounded-3 bg-white fade-in-up mb-5 mt-5" style="border: 2px solid #00A86B;">
            <div class="card-body p-5 text-center">
                <h1 class="fw-bold mb-2" id="deckName" style="color: #00A86B;">Cargando...</h1>
                <p class="text-muted mb-3" id="deckDescription"></p>

                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-auto">
                        <div class="stat-box">
                            <div class="stat-value" id="totalCards">0</div>
                            <div class="stat-label ">Cartas</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="agregar_cartas.php?deck_id=<?= $deck_id ?>" class="btn btn-lg w-100" style="background: #00A86B; color: white;">
                            Agregar Cartas
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="gestionar_cartas.php?deck_id=<?= $deck_id ?>" class="btn btn-outline-secondary btn-lg w-100">
                            Gestionar Cartas
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="editar_mazo.php?deck_id=<?= $deck_id ?>" class="btn btn-outline-secondary btn-lg w-100">
                            Editar Información
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-danger btn-lg w-100 btnEliminarMazo" data-id="<?= $deck_id ?>">
                            Eliminar Mazo
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div id="cardsContainer" class="row g-4 mb-4">
            <div class="col-12 text-center">
                <div class="spinner-border text-white" role="status">
                    <!-- <span class="visually-hidden">Cargando...</span> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/verMazo.js"></script>