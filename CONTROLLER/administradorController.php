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
            $password = $_POST['password'];
            
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
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO usuarios (nombre, correo, numero_ficha, password, rol, puntaje_total) VALUES (?, ?, NULL, ?, 'admin', 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $password_hash]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Administrador creado exitosamente'
            ]);
        }
        
        elseif ($accion === 'editar') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $password = $_POST['password'];
            
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
            
            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET nombre = ?, correo = ?, password = ? WHERE id = ? AND rol = 'admin'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nombre, $correo, $password_hash, $id]);
            } else {
                $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ? AND rol = 'admin'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nombre, $correo, $id]);
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Administrador actualizado exitosamente'
            ]);
        }
        
        elseif ($accion === 'eliminar') {
            $id = $_POST['id'];
            
            // // Verificar que no sea el último administrador
            // $sqlCount = "SELECT COUNT(*) as total FROM usuarios WHERE rol = 'admin'";
            // $stmtCount = $pdo->prepare($sqlCount);
            // $stmtCount->execute();
            // $result = $stmtCount->fetch(PDO::FETCH_ASSOC);
            
            // if ($result['total'] <= 1) {
            //     echo json_encode([
            //         'success' => false,
            //         'message' => 'No se puede eliminar el último administrador del sistema'
            //     ]);
            //     exit();
            // }
            
            $sql = "DELETE FROM usuarios WHERE id = ? AND rol = 'admin'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Administrador eliminado exitosamente'
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
