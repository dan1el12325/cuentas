<?php

require_once '../db/connection.php';

session_start();

$idUser = $_SESSION['id_user'];

$conn = (new Connection())->getConnection();

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $cardId = $_GET['card-id'] ?? null;
    getExpenses($conn, $idUser, $cardId);
}

function getExpenses($conn , $idUser, $cardId = null){
    if($cardId){
        try{
            $sql = 'SELECT * FROM gastos WHERE id_usuario = :idUser AND id_tarjeta = :cardId';
            $stmt = $conn -> prepare($sql);
            $stmt -> execute([
                ":idUser" => $idUser,
                ":cardId" => $cardId
            ]);
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
            echo json_encode([
                "success" => true,
                "data" => $result,
                "cardId" => $cardId
            ]);
        }catch(PDOException $e){
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }else{
        $sql = 'SELECT * FROM gastos WHERE id_usuario = :idUser';
        $stmt = $conn -> prepare($sql);
        $stmt -> execute([
            ":idUser" => $idUser
        ]);
        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if($result){
            echo json_encode([
                "success" => true,
                "message" => "Gastos Cargados"
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Ocurrio un error al cargar los datos"
            ]);
        }
    }
}