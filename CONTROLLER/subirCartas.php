<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deck_id"]) && !empty($_POST["deck_id"])) {
        
        require_once '../model/MySQL.php';
        
        $mysql = new MySQL();
        $mysql->conectar();
        $pdo = $mysql->getConexion();
        
        $deck_id = intval($_POST["deck_id"]);
        $upload_dir = "../cards/";
        $uploaded_cards = [];
        $errors = [];
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        if (!isset($_FILES['card_images']) || empty($_FILES['card_images']['tmp_name'])) {
            echo json_encode([
                "success" => false,
                "message" => "No se seleccionaron archivos"
            ]);
            exit;
        }
        
        try {
            foreach ($_FILES['card_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['card_images']['error'][$key] == 0) {
                    
                    $file_type = $_FILES['card_images']['type'][$key];
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    
                    if (!in_array($file_type, $allowed_types)) {
                        $errors[] = $_FILES['card_images']['name'][$key] . " (tipo no permitido)";
                        continue;
                    }
                    
                    $filename = time() . "_" . $key . "_" . basename($_FILES['card_images']['name'][$key]);
                    $upload_path = $upload_dir . $filename;
                    $db_path = "cards/" . $filename;
                    
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        $nombre_carta = basename($_FILES['card_images']['name'][$key]);
                        $sql = "INSERT INTO cartas (id_mazo, nombre, imagen_frente, imagen_atras) VALUES (?, ?, ?, ?)";
                        $stmt = $pdo->prepare($sql);
                        $resultado = $stmt->execute([$deck_id, $nombre_carta, $db_path, $db_path]);
                        
                        if ($resultado) {
                            $uploaded_cards[] = [
                                'id' => $pdo->lastInsertId(),
                                'image' => $db_path
                            ];
                        }
                    } else {
                        $errors[] = $_FILES['card_images']['name'][$key];
                    }
                }
            }
        } catch (PDOException $e) {
            echo json_encode([
                "success" => false,
                "message" => "Error al subir cartas: " . $e->getMessage()
            ]);
            $mysql->desconectar();
            exit;
        }
        
        $mysql->desconectar();
        
        if (count($uploaded_cards) > 0) {
            echo json_encode([
                "success" => true,
                "message" => "Se agregaron " . count($uploaded_cards) . " carta(s) exitosamente",
                "uploaded_cards" => $uploaded_cards,
                "errors" => $errors
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No se pudo subir ninguna carta",
                "errors" => $errors
            ]);
        }
        
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
