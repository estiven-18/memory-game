<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Aceptar tanto 'id' como 'deck_id' como parámetro
    $deck_id = isset($_GET["id"]) ? $_GET["id"] : (isset($_GET["deck_id"]) ? $_GET["deck_id"] : null);
    
    if ($deck_id && !empty($deck_id)) {
        
        require_once '../model/MySQL.php';
        
        $mysql = new MySQL();
        $mysql->conectar();
        $pdo = $mysql->getConexion();
        
        try {
            $sql = "SELECT id, nombre as name, descripcion as description FROM mazos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$deck_id]);
            $deck = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($deck) {
                //* Obtener las cartas del mazo con todo los necesarios
                $sqlCards = "SELECT id, nombre, imagen_frente, imagen_atras FROM cartas WHERE id_mazo = ?";
                $stmtCards = $pdo->prepare($sqlCards);
                $stmtCards->execute([$deck_id]);
                $cartas = $stmtCards->fetchAll(PDO::FETCH_ASSOC);
                
                //* Crear array de cards con alias para compatibilidad con ver_mazo.php
                $cards = array_map(function($carta) {
                    return [
                        'id' => $carta['id'],
                        'name' => $carta['nombre'],
                        'image' => $carta['imagen_frente'],
                        'nombre' => $carta['nombre'],
                        'imagen_frente' => $carta['imagen_frente'],
                        'imagen_atras' => $carta['imagen_atras']
                    ];
                }, $cartas);
                
                echo json_encode([
                    "success" => true,
                    "deck" => $deck,
                    "cards" => $cards,
                    "cartas" => $cards
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
