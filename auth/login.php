<?php

require_once '../db/connection.php';

$conn = new Connection();

header("Content-Type: application/json");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $result = $conn -> login($username, $password);
    if($result['success'] === true){
        $_SESSION['username'] = $username;
    }
    echo json_encode($result);
}