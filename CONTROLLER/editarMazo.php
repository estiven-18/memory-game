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
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    if ($accion === 'editar_mazo') {
        $mazo_id = isset($_POST['mazo_id']) ? $_POST['mazo_id'] : null;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
        
        if (!$mazo_id || !$nombre) {
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
            $sql = "UPDATE mazos SET nombre = ?, descripcion = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $descripcion, $mazo_id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Mazo actualizado exitosamente'
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
            'message' => 'Acción no válida'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
