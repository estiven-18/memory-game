<?php
$pagina = "Inicio";

session_start();

$rol = $_SESSION['rol'];

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

// Cargar mazos desde la base de datos
require_once '../model/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
$pdo = $mysql->getConexion();

try {
    $sql = "SELECT mazos.id, mazos.nombre as name, mazos.descripcion as description, COUNT(cartas.id) as total_cards 
            FROM mazos 
            LEFT JOIN cartas ON mazos.id = cartas.id_mazo 
            WHERE mazos.estado = 'activo'
            GROUP BY mazos.id 
            ORDER BY mazos.id DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $mazos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mazos = [];
    $error = "Error al obtener los mazos: " . $e->getMessage();
}

$mysql->desconectar();
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<div class="main-container">
    <div class="container">

        <!-- Header -->
        <div class="text-center mt-5 mb-5 fade-in-up" style="color: #333;">
            <h1 class="display-3 fw-bold mb-3">
                Mazos Disponibles
            </h1>
            
        </div>

        <!-- Grid de mazos -->
        <div class="row g-4">
            <?php if (empty($mazos)): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4 bg-white">
                        <div class="card-body text-center py-5">
                            <h3 class="text-muted mb-3">No tienes mazos todavía</h3>
                            <p class="text-secondary mb-4">Crea tu primer mazo para comenzar a jugar</p>
                            <a href="crear_mazo.php" class="btn btn-lg" style="background: #00A86B; color: white;">
                                Crear Mi Primer Mazo
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($mazos as $mazo): ?>
                    <?php $puedeJugar = $mazo['total_cards'] >= 5; ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card card-deck-item h-100 shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold mb-2" style="color: #00A86B;">
                                    <?php echo htmlspecialchars($mazo['name']); ?>
                                </h5>
                                <p class="card-text text-center text-muted small mb-3">
                                    <?php echo htmlspecialchars($mazo['description'] ?: 'Sin descripción'); ?>
                                </p>
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <h4 class="mb-0" style="color: #00A86B;"><?php echo $mazo['total_cards']; ?></h4>
                                            <small class="text-muted">Cartas</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <h4 class="mb-0" style="color: #00A86B;"><?php echo $mazo['total_cards'] * 2; ?></h4>
                                            <small class="text-muted">Piezas</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <?php if ($puedeJugar): ?>
                                        <!-- poner hover cuando se pueda jugar -->
                                        <a href="seleccionar_dificultad.php?deck_id=<?php echo $mazo['id']; ?>" 
                                    
                                           class="btn" style="background: #00A86B; color: white;  ;">
                                    
                                            Jugar
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($rol === 'admin' || $rol === 'ADMIN'): ?>
                                        <div class="btn-group">
                                            <a href="ver_mazo.php?deck_id=<?php echo $mazo['id']; ?>" 
                                               class="btn  btn-outline-secondary btn-sm" >
                                                Ver
                                            </a>
                                            <a href="agregar_cartas.php?deck_id=<?php echo $mazo['id']; ?>" 
                                               class="btn btn-outline-secondary btn-sm">
                                                Agregar
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once './layout/footer.php'; ?>