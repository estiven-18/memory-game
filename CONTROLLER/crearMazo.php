<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && !empty(trim($_POST["name"]))) {
        
        require_once '../model/MySQL.php';
        
        $mysql = new MySQL();
        $mysql->conectar();
        $pdo = $mysql->getConexion();
        
        $nombre = filter_var(trim($_POST["name"]), FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = isset($_POST["description"]) ? filter_var(trim($_POST["description"]), FILTER_SANITIZE_SPECIAL_CHARS) : '';
        
        try {
            $sql = "INSERT INTO mazos (nombre, descripcion) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([$nombre, $descripcion]);
            
            if ($resultado) {
                $deckId = $pdo->lastInsertId();
                echo json_encode([
                    "success" => true,
                    "message" => "¡Mazo creado exitosamente!",
                    "deck_id" => $deckId
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Error al crear el mazo"
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
            "message" => "El nombre del mazo es obligatorio"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
?>
