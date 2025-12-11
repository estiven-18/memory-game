<?php
$pagina = "Gestionar Cartas";

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION["rol"] != 'admin') {
    header('location: ./login.php');
    exit();
}

$deck_id = isset($_GET['deck_id']) ? $_GET['deck_id'] : null;

if (!$deck_id) {
    header('location: ./index.php');
    exit();
}

require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

//* obetrn información del mazo 
$sql = "SELECT nombre, descripcion FROM mazos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$deck_id]);
$mazo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mazo) {
    $mysql->desconectar();
    header('location: ./index.php');
    exit();
}

$sqlCards = "SELECT id, nombre, imagen_frente, imagen_atras FROM cartas WHERE id_mazo = ? ORDER BY id DESC";
$stmtCards = $pdo->prepare($sqlCards);
$stmtCards->execute([$deck_id]);
$cartas = $stmtCards->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();

if (!$mazo) {
    header('location: ./index.php');
    exit();
}

require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="../ASSETS/css/gestionar_cartas.css">

<div class="container mt-5">
    <div class="text-center mt-5 mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color: #333;">
            Gestionar Cartas
        </h1>
    </div>
    <div class="card shadow">

        <div class="card-body">
            <?php if (count($cartas) > 0): ?>
                <div class="cartas-grid-container">
                    <?php foreach ($cartas as $carta): ?>
                        <div class="carta-card">
                            <img src="../<?php echo htmlspecialchars($carta['imagen_frente']); ?>"
                                alt="Carta"
                                class="carta-card-img">
                            <div class="carta-card-body">
                                <div class="carta-card-nombre">
                                </div>
                                <div class="carta-card-actions">
                                    <button class="btn btn-danger btn-eliminar-carta btnEliminarCarta" data-id="<?php echo $carta['id']; ?>">
                                        <i class="fas fa-trash me-2"></i>Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-cartas">
                    <i class="fas fa-inbox"></i>
                    <p class="fs-5">No hay cartas en este mazo</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once './layout/footer.php'; ?>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../ASSETS/js/gestionarCartas.js"></script>
<script>
    const deckId = <?php echo $deck_id; ?>;
</script>