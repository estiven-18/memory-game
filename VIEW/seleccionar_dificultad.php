<?php
$pagina = "Seleccionar Dificultad";

session_start();

//* verificar que el usuario este logueado 
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}


$deck_id = $_GET['deck_id'];

//* si no hay mazo en la url redirigir al inicio
if (!$deck_id) {
    header('location: ./index.php');
    exit();
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="main-container">
    <div class="container">
        
        <div class="text-center mt-5 mb-5">
            <h1 class="display-4 fw-bold mb-3" style="color: #333;">
                Selecciona la Dificultad
            </h1>
        </div>

        <div class="row g-4 justify-content-center mb-5">
            
            <div class="col-md-4">
                <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=facil" 
                   class="card h-100 border-0 shadow-sm text-decoration-none dificultad-facil" 
                   style="border: 2px solid #00A86B !important; transition: all 0.3s;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4" style="font-size: 3rem; color: #00A86B;">●</div>
                        <h3 class="fw-bold mb-3" style="color: #00A86B;">Fácil</h3>
                        <div class="pt-3" style="border-top: 2px solid #e9ecef;">
                            <div class="fs-4 fw-bold text-dark">5 parejas</div>
                            <small class="text-muted">10 cartas en total</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=medio" 
                   class="card h-100 border-0 shadow-sm text-decoration-none dificultad-medio" 
                   style="border: 2px solid #ffc107 !important; transition: all 0.3s;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4" style="font-size: 3rem; color: #ffc107;">●●</div>
                        <h3 class="fw-bold mb-3" style="color: #ffc107;">Medio</h3>
                        <div class="pt-3" style="border-top: 2px solid #e9ecef;">
                            <div class="fs-4 fw-bold text-dark">8 parejas</div>
                            <small class="text-muted">16 cartas en total</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=dificil" 
                   class="card h-100 border-0 shadow-sm text-decoration-none dificultad-dificil" 
                   style="border: 2px solid #dc3545 !important; transition: all 0.3s;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4" style="font-size: 3rem; color: #dc3545;">●●●</div>
                        <h3 class="fw-bold mb-3" style="color: #dc3545;">Difícil</h3>
                        <div class="pt-3" style="border-top: 2px solid #e9ecef;">
                            <div class="fs-4 fw-bold text-dark">12 parejas</div>
                            <small class="text-muted">24 cartas en total</small>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
</div>

<?php require_once './layout/footer.php'; ?>
