<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../MODEL/MySQL.php';
    
    
    $rol = $_POST['rol'] ;
    $correo = $_POST['correo'] ;
    $numero_ficha = $_POST['numero_ficha'] ;
    $password = $_POST['password'] ;
    
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        if ($rol === 'ADMIN') {
            //* login para el admin
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND rol = 'ADMIN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['rol'] = $usuario['rol'];
                
                echo json_encode([
                    "success" => true,
                    "message" => "Bienvenido Administrador",
                    "redirect" => "index.php"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Credenciales incorrectas"
                ]);
            }
            
        } else {
            //* login para el jugador
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND numero_ficha = ? AND rol = 'JUGADOR'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$correo, $numero_ficha]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['numero_ficha'] = $usuario['numero_ficha'];
                $_SESSION['rol'] = $usuario['rol'];
                
                echo json_encode([
                    "success" => true,
                    "message" => "Bienvenido " . $usuario['nombre'],
                    "redirect" => "index.php"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Credenciales incorrectas"
                ]);
            }
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
