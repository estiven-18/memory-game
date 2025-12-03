<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["deck_id"]) && !empty($_GET["deck_id"])) {
        
        require_once '../model/MySQL.php';
        
        $mysql = new MySQL();
        $mysql->conectar();
        $pdo = $mysql->getConexion();
        
        $deck_id = $_GET["deck_id"];
        
        try {
            $sql = "SELECT id, nombre as name, descripcion as description FROM mazos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$deck_id]);
            $deck = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($deck) {
                // Obtener las cartas del mazo
                $sqlCards = "SELECT id, nombre as name, imagen_frente as image FROM cartas WHERE id_mazo = ?";
                $stmtCards = $pdo->prepare($sqlCards);
                $stmtCards->execute([$deck_id]);
                $cards = $stmtCards->fetchAll(PDO::FETCH_ASSOC);
                
                echo json_encode([
                    "success" => true,
                    "deck" => $deck,
                    "cards" => $cards
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Mazo no encontrado"
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
