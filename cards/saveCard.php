<?php

require_once '../db/connection.php';

$conn = new Connection();

session_start();
$idUser = $_SESSION['id_user'];
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $bin = $_POST['bin'];
    $last4 = $_POST['last4'];
    $bank = $_POST['bank'];
    $brand = $_POST['brand'];
    $alias = $_POST['alias'];
    $cardType = strtoupper($_POST['card-type']);
    $creditLimit = $_POST['credit-limit'] ?? null;
    $closingDate = $_POST['closing-date'] ?? null;
    $dueDate = $_POST['due-date'] ?? null;

    $result = $conn -> saveCard($idUser, $bin, $last4, $bank, $brand, $alias, $cardType, $creditLimit, $closingDate, $dueDate);
    if($result){
        echo json_encode([
            "success" => true,
            "message" => "Tarjeta registrada"
        ]);
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Hubo un error al guardar la tarjeta"
        ]);
    }
}