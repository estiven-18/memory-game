<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once '../model/MySQL.php';
    
    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();
    
    try {
        $sql = "SELECT mazos.id, mazos.nombre as name, mazos.descripcion as description, COUNT(cartas.id) as total_cards 
                FROM mazos 
                LEFT JOIN cartas  ON mazos.id = cartas.id_mazo 
                WHERE mazos.estado = 'activo'
                GROUP BY mazos.id 
                ORDER BY mazos.id DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $mazos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            "success" => true,
            "data" => $mazos
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Error al obtener los mazos: " . $e->getMessage()
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
