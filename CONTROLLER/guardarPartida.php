<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../model/MySQL.php';


    //! esta bueno pero mirara como cambiar a fetch para manejar errores mas facil
    $datos = json_decode(file_get_contents('php://input'), true);

    $id_jugador = $datos['id_jugador'];
    $id_mazo = $datos['id_mazo'];
    $dificultad = $datos['dificultad'];
    $puntaje_obtenido = $datos['puntaje_obtenido'];
    $movimientos = $datos['movimientos'];

    $mysql = new MySQL();
    $mysql->conectar();
    $pdo = $mysql->getConexion();

    try {
        //* Preparar la consulta SQL para insertar la partida
        $sql = "INSERT INTO partidas (id_jugador, id_mazo, dificultad, puntaje_obtenido, movimientos, fecha) 
                VALUES (:id_jugador, :id_mazo, :dificultad, :puntaje_obtenido, :movimientos, NOW())";

        //* Preparar el statement
        $stmt = $pdo->prepare($sql);

        //* Vincular los parámetros  
        $stmt->bindParam(':id_jugador', $id_jugador, PDO::PARAM_INT);
        $stmt->bindParam(':id_mazo', $id_mazo, PDO::PARAM_INT);
        $stmt->bindParam(':dificultad', $dificultad, PDO::PARAM_STR);
        $stmt->bindParam(':puntaje_obtenido', $puntaje_obtenido, PDO::PARAM_INT);
        $stmt->bindParam(':movimientos', $movimientos, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if ($resultado) {
            $id_partida = $pdo->lastInsertId();
            
            //* Actualizar el puntaje total del jugador
            $sqlActualizar = "UPDATE usuarios 
                             SET puntaje_total = puntaje_total + :puntaje 
                             WHERE id = :id_jugador";

            $stmtActualizar = $pdo->prepare($sqlActualizar);
            $stmtActualizar->bindParam(':puntaje', $puntaje_obtenido, PDO::PARAM_INT);
            $stmtActualizar->bindParam(':id_jugador', $id_jugador, PDO::PARAM_INT);
            $stmtActualizar->execute();

            //* Responder con éxito
            echo json_encode([
                'success' => true,
                'message' => 'Partida guardada correctamente',
                'id_partida' => $id_partida
            ]);
        } else {
            //* Error al insertar
            echo json_encode([
                'success' => false,
                'message' => 'Error al guardar la partida'
            ]);
        }
    } catch (PDOException $e) {
        //* Error en la base de datos
        echo json_encode([
            'success' => false,
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ]);
    }

    // Cerrar conexión
    $mysql->desconectar();
} else {
    //* No es una petición POST
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
