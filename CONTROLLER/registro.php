<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../model/MySQL.php';
    
    $rol = isset($_POST['rol']) ? $_POST['rol'] : 'JUGADOR';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $numero_ficha = isset($_POST['numero_ficha']) ? $_POST['numero_ficha'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
   
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$correo]);
        
        if ($stmtCheck->fetch()) {
            echo json_encode([
                "success" => false,
                "message" => "El correo ya está registrado"
            ]);
            exit;
        }
        
        if ($rol === 'ADMIN') {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO usuarios (nombre, correo, password, rol, puntaje_total) VALUES (?, ?, ?, 'ADMIN', 0)";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([$nombre, $correo, $password_hash]);
            
        } else {
            
            
            $sql = "INSERT INTO usuarios (nombre, correo, numero_ficha, rol, puntaje_total) VALUES (?, ?, ?, 'JUGADOR', 0)";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([$nombre, $correo, $numero_ficha]);
        }
        
        if ($resultado) {
            echo json_encode([
                "success" => true,
                "message" => "Registro exitoso. Ya puedes iniciar sesión"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error al registrar usuario"
            ]);
        }
        
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Error: " . $e->getMessage()
        ]);
    }
    
    $mysql->desconectar();
    
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
?>
