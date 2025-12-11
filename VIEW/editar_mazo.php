<?php
$pagina = "Editar Mazo";

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

$mysql->desconectar();

if (!$mazo) {
    header('location: ./index.php');
    exit();
}

require_once './layout/header.php';
require_once './layout/navbar.php';
?>
<link rel="stylesheet" href="../ASSETS/css/editar_mazo.css">
<div class="container mt-5">
    <div class="text-center  mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color: #333;">
            Editar Mazo
        </h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h4 class="mb-0">Editar Información del Mazo</h4>
                </div>
                <div class="card-body">
                    <form id="formEditarMazo">
                        <input type="hidden" id="mazo_id" value="<?php echo $deck_id; ?>">
                        
                        <div class="mb-3">
                            <label for="nombre_mazo" class="form-label">Nombre del Mazo</label>
                            <input type="text" class="form-control" id="nombre_mazo" value="<?php echo htmlspecialchars($mazo['nombre']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion_mazo" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_mazo" rows="4"><?php echo htmlspecialchars($mazo['descripcion']); ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn text-white">
                                Guardar Cambios
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
<script src="../ASSETS/js/editarMazoInfo.js"></script>
<script>
    const deckId = <?php echo $deck_id; ?>;
</script>
