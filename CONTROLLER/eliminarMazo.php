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
            $sqlCartas = "SELECT imagen_frente FROM cartas WHERE id_mazo = ?";
            $stmtCartas = $pdo->prepare($sqlCartas);
            $stmtCartas->execute([$deck_id]);
            $cartas = $stmtCartas->fetchAll(PDO::FETCH_ASSOC);
            
            // Eliminar archivos de imágenes
            foreach ($cartas as $carta) {
                $imagePath = "../" . $carta['imagen_frente'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Eliminar cartas primero (foreign key)
            $sqlDeleteCartas = "DELETE FROM cartas WHERE id_mazo = ?";
            $stmtDeleteCartas = $pdo->prepare($sqlDeleteCartas);
            $stmtDeleteCartas->execute([$deck_id]);
            
            // Luego eliminar el mazo
            $sql = "DELETE FROM mazos WHERE id = ?";
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
