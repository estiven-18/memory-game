<?php
$pagina = "Crear Mazo";
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="main-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 bg-white fade-in-up mt-5 mb-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold" style="color: #00A86B;">Crear Nuevo Mazo</h2>
                            <p class="text-muted">Crea un mazo personalizado</p>
                        </div>

                        <form id="formCrearMazo">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    Nombre del Mazo </span>
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg"
                                    id="name"
                                    name="name"
                                    maxlength="50"
                                    required>
                                
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    Descripción
                                </label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    maxlength="200"></textarea>

                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit"
                                    id="btnCrearMazo"
                                    class="btn btn-lg" style="background: #00A86B; color: white;">
                                    Crear Mazo
                                </button>
                                <a href="index.php" class="btn btn-lg btn-outline-secondary">
                                    Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>
<script src="../ASSETS/js/crearMazo.js"></script>