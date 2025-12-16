<?php

//* NO SE PUEDE ENTRAR SI NO ERES ADMIN

$pagina = "Agregar Cartas";

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION["rol"] != 'admin') {
    header('location: ./login.php');
}

$deck_id = $_GET['deck_id'];


require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="../ASSETS/css/agregar_cartas.css">

<div class="main-container">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mt-5 mb-3" style="color: #333;">
            Agregar Cartas
        </h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 bg-white fade-in-up mb-5">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold" style="color: #00A86B;">Agregar Cartas al Mazo</h2>
                        </div>

                        <form id="formSubirCartas" enctype="multipart/form-data">
                            <input type="hidden" id="deck_id_input" name="deck_id" value="<?= $deck_id ?>">

                            <div class="mb-4">
                                <div class="drop-zone" id="dropZone">
                                    <h5>Arrastra y suelta las imágenes aquí o</h5>
                                    
                                    <p class=" text-muted">Puede seleccionar múltiples imágenes a la vez dejando presionada la tecla Ctrl y clicando las imágenes que desees seleccionar.</p>
                                    <p class=" text-danger">¡Solo agregar 12 cartas!</p>

                                </div>
                                <input type="file"
                                    id="card_images"
                                    name="card_images[]"
                                    accept="image/*"
                                    multiple
                                    required
                                    style="display: none;">
                            </div>

                            <div id="selectedCount" class="alert alert-success d-none mb-4">
                                <strong><span id="countNumber">0</span></strong> carta(s) seleccionada(s)
                            </div>

                            <div id="previewContainer" class="cards-preview-container mb-4"></div>

                            <div class="d-grid gap-2">
                                <button type="submit"
                                    id="btnSubirCartas"
                                    class="btn btn-lg"
                                    style="background: #00A86B; color: white;"
                                    disabled>
                                    Guardar Cartas
                                </button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/agregarCartas.js"></script>