<?php
$pagina = "Seleccionar Dificultad";

session_start();

//* verificar que el usuario este logueado 
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

// $deck_id = isset($_GET['deck_id']) ? $_GET['deck_id'] : null;

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

<!-- <?php if (isset($_SESSION['error_message'])): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'No se puede jugar',
                text: '<?php echo $_SESSION['error_message']; ?>',
                confirmButtonText: 'Entendido'
            });
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?> -->

<link rel="stylesheet" href="../ASSETS/css/seleccionar_dificultad.css">

<div class="dificultad-container">
    <div class="titulo">
        <h1>Selecciona la Dificultad</h1>
        <p>Elige el nivel que prefieras para comenzar a jugar</p>
    </div>
<!--cambiar la cantidad de lad caratssssssssssssssssssssssssssssssssssssssssssssssssssssss -->
    <div class="niveles">

        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=facil" class="nivel-card facil" id="btnFacil">
            <div class="nivel-titulo">Fácil</div>
            
            <div class="nivel-detalles">
                5 parejas (10 cartas)<br>
            </div>
        </a>

        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=medio" class="nivel-card medio" id="btnMedio">
            <div class="nivel-titulo">Medio</div>
            
            <div class="nivel-detalles">
                8 parejas (16 cartas)<br>
            </div>
        </a>

        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=dificil" class="nivel-card dificil" id="btnDificil">
            <div class="nivel-titulo">Difícil</div>
            
            <div class="nivel-detalles">
                12 parejas (24 cartas)<br>
            </div>
        </a>
    </div>

    <a href="index.php" class="btn-volver"> Volver al Inicio</a>
</div>

<?php require_once './layout/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../ASSETS/js/seleccionar_dificultad.js"></script>
