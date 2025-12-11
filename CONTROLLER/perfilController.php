<?php
session_start();
header('Content-Type: application/json');

require_once '../model/MySQL.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    // Verificar que el usuario esté autenticado
    if (!isset($_SESSION['usuario_id']) || !$_SESSION['acceso']) {
        echo json_encode([
            'success' => false,
            'message' => 'No tiene autorización para realizar esta acción'
        ]);
        exit();
    }
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        
        if ($accion === 'editar_perfil') {
            $usuario_id = $_SESSION['usuario_id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            
            
            
            $sqlCheck = "SELECT id FROM usuarios WHERE correo = ? AND id != ?";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$correo, $usuario_id]);
            
            if ($stmtCheck->rowCount() > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El correo ya está registrado en otro usuario'
                ]);
                exit();
            }
            
            $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $usuario_id]);
            
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;            
            echo json_encode([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente'
            ]);
        }
        
        else {
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
        }
        
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
