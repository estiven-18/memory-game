<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //* verificar que el usuario sea admin
    if (!isset($_SESSION['acceso']) || !$_SESSION['acceso'] || $_SESSION['rol'] !== 'admin') {
        echo json_encode([
            'success' => false,
            'message' => 'No tiene autorización para realizar esta acción'
        ]);
        exit();
    }
    
    require_once '../model/MySQL.php';
    
    $carta_id = isset($_POST['carta_id']) ? $_POST['carta_id'] : null;
    $deck_id = isset($_POST['deck_id']) ? $_POST['deck_id'] : null;
    
    if (!$carta_id || !$deck_id) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit();
    }
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        //* obtener las rutas de las imágenes antes de eliminar
        $sqlGetImage = "SELECT imagen_frente, imagen_atras FROM cartas WHERE id = ? AND id_mazo = ?";
        $stmtGetImage = $pdo->prepare($sqlGetImage);
        $stmtGetImage->execute([$carta_id, $deck_id]);
        $carta = $stmtGetImage->fetch(PDO::FETCH_ASSOC);
        
        if (!$carta) {
            echo json_encode([
                'success' => false,
                'message' => 'Carta no encontrada'
            ]);
            exit();
        }
        
        //* eliminar la carta de la base de datos
        $sql = "DELETE FROM cartas WHERE id = ? AND id_mazo = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$carta_id, $deck_id]);
        
        //* eliminar las imágenes del servidor si existen
        if ($carta['imagen_frente'] && file_exists('../' . $carta['imagen_frente'])) {
            unlink('../' . $carta['imagen_frente']);
        }
        if ($carta['imagen_atras'] && file_exists('../' . $carta['imagen_atras'])) {
            unlink('../' . $carta['imagen_atras']);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Carta eliminada exitosamente'
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ]);
    }
    
    $mysql->desconectar();
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
