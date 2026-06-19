<?php

require_once '../db/connection.php';

$conn = new Connection();

header("Content-Type: application/json");


session_start();

$idUser = $_SESSION['id_user'];

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $cardId = $_GET['cardId'] ?? null;

    if($cardId){

    //cambiar consulta pidiendo el id de usuario tambien
        $sql = 'SELECT *, nombre FROM tarjetas INNER JOIN usuarios ON tarjetas.id_usuario = usuarios.id_usuario WHERE tarjetas.id_tarjeta = :id ';

        $stmt = $conn -> conn -> prepare($sql);

        $stmt -> execute([
            ":id" => $cardId
        ]);

        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        if($result){
            echo json_encode([
                "success" => true,
                "message" => "TARJETAS CON FILTRO",
                "data" => $result,
                "id usado" => $cardId
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "NO SE ENCONTRO LA TARJETA ESPECIFICADA"
            ]);
        }
    }else{
        $sql = 'SELECT *, nombre FROM tarjetas INNER JOIN usuarios ON tarjetas.id_usuario = usuarios.id_usuario WHERE tarjetas.id_usuario = :id_usuario';

        $stmt = $conn -> conn -> prepare($sql);

        $stmt -> execute([
            ':id_usuario' => $idUser
        ]);

        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        if($result){
            echo json_encode([
                "success" => true,
                "message" => "TARJETAS ENCONTRADAS",
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