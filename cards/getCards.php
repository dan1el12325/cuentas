<?php

require_once '../db/connection.php';

$conn = new Connection();

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $cardId = $_GET['id'] ?? null;

    if($cardId){

    //cambiar consulta pidiendo el id de usuario tambien
        $sql = 'SELECT * FROM tarjetas WHERE id_tarjeta = :id';

        $stmt = $conn -> conn -> prepare($sql);

        $stmt -> execute([
            ":id" => $cardId
        ]);

        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        if($result){
            echo json_encode([
                "success" => true,
                "message" => "HAY TARJETAS"
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "NO SE ENCONTRO LA TARJETA"
            ]);
        }
    }else{
        $sql = 'SELECT *, nombre FROM tarjetas INNER JOIN usuarios ON tarjetas.id_usuario = usuarios.id_usuario';

        $stmt = $conn -> conn -> prepare($sql);

        $stmt -> execute();

        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        if($result){
            echo json_encode([
                "success" => true,
                "message" => "HAY TARJETAS",
                "data" => $result
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "NO SE ENCONTRARON TARJETAS REGISTRADAS"
            ]);
        }
    }
}