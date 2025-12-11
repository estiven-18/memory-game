<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deck_id"]) && !empty($_POST["deck_id"])) {
        
        require_once '../model/MySQL.php';
        
        $mysql = new MySQL();
        $mysql->conectar();
        $pdo = $mysql->getConexion();
        
        $deck_id = intval($_POST["deck_id"]);
        
        try {
            // Cambiar estado del mazo a "eliminado" en lugar de borrarlo
            $sql = "UPDATE mazos SET estado = 'eliminado' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([$deck_id]);
            
            if ($resultado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Mazo eliminado exitosamente"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Error al eliminar el mazo"
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
            "message" => "ID de mazo no especificado"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
?>
