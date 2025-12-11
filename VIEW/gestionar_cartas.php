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
<style>
    .cartas-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        padding: 20px 0;
    }

    .carta-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .carta-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .carta-card-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }

    .carta-card-body {
        padding: 20px;
    }

    .carta-card-nombre {
        font-weight: 600;
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 15px;
        text-align: center;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .carta-card-actions {
        display: flex;
        justify-content: center;
    }

    .btn-eliminar-carta {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        font-weight: 600;
    }

    .no-cartas {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-cartas i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
</style>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0"><i class="fas fa-layer-group me-2"></i>Gestionar Cartas - <?php echo htmlspecialchars($mazo['nombre']); ?></h4>
        </div>
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
            <div class="mt-3">
                <a href="ver_mazo.php?deck_id=<?php echo $deck_id; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
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