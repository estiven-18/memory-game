<?php
header('Content-Type: application/json');


require_once '../model/MySQL.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        
        if ($accion === 'crear') {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $numero_ficha = $_POST['numero_ficha'];
            
            $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$correo]);
            
            if ($stmtCheck->rowCount() > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El correo ya está registrado'
                ]);
                exit();
            }
            
            $sql = "INSERT INTO usuarios (nombre, correo, numero_ficha, password, rol, puntaje_total) VALUES (?, ?, ?, ?, 'jugador', 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $numero_ficha, $numero_ficha]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Jugador creado exitosamente'
            ]);
        }
        
        elseif ($accion === 'editar') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $numero_ficha = $_POST['numero_ficha'];
            
            $sqlCheck = "SELECT id FROM usuarios WHERE correo = ? AND id != ?";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$correo, $id]);
            
            if ($stmtCheck->rowCount() > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El correo ya está registrado en otro usuario'
                ]);
                exit();
            }
            
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, numero_ficha = ?, password = ? WHERE id = ? AND rol = 'jugador'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $numero_ficha, $numero_ficha, $id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Jugador actualizado exitosamente'
            ]);
        }
        
        elseif ($accion === 'eliminar') {
            $id = $_POST['id'];
            
            $sql = "DELETE FROM usuarios WHERE id = ? AND rol = 'jugador'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Jugador eliminado exitosamente'
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
