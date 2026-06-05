<?php

require_once '../db/connection.php';

$conn = new Connection();

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $fullName = $_POST['fullname'];
    $password = $_POST['password'];
    $user = $conn -> userExists($username);

    if(!$user){
        $creationDate = date("Y-m-d H:i:s");
        $conn -> createUser($username, $fullName, $password, $creationDate);
    }else{
        echo json_encode([
            "success" => false,
            "message" => "An user with this username already exists"
        ]);
    }
}
