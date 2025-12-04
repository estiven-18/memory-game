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

        <div class="card border-0 shadow-lg rounded-4 bg-white fade-in-up mb-4 mt-5 ">
            <div class="card-body p-4 p-md-5 text-center">
                <h1 class="fw-bold mb-2" id="deckName" style="color: #00A86B;">Cargando...</h1>
                <p class="text-muted mb-3" id="deckDescription"></p>

                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-auto">
                        <div class="stat-box">
                            <div class="stat-value" id="totalCards">0</div>
                            <div class="stat-label">Cartas</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="seleccionar_dificultad.php?deck_id=<?= $deck_id ?>"
                        id="btnJugar"
                        class="btn btn-lg d-none" style="background: #00A86B; color: white;">
                        Jugar
                    </a>
                    <a href="agregar_cartas.php?deck_id=<?= $deck_id ?>" class="btn btn-lg" style="background: #00A86B; color: white;">
                        Agregar Cartas
                    </a>
                    <button class="btn btn-danger btn-lg btnEliminarMazo" data-id="<?= $deck_id ?>">
                        Eliminar
                    </button>
                    <a href="index.php" class="btn btn-lg btn-outline-secondary">
                        Inicio
                    </a>
                </div>
            </div>
        </div>

        <!-- Grid de Cartas -->
        <div id="cardsContainer" class="row g-4 mb-4">
            <div class="col-12 text-center">
                <div class="spinner-border text-white" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/verMazo.js"></script>