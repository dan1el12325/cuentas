<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['cardBin'])) {
        echo json_encode(["error" => "Falta cardBin"]);
        exit;
    }

    $cardBin = $_GET['cardBin'];

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => "https://lookup.binlist.net/" . $cardBin,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Accept-Version: 3",
            "User-Agent: Mozilla/5.0"
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo json_encode(["error" => curl_error($ch)]);
        exit;
    }

    curl_close($ch);

    echo json_encode([
        "http" => $httpCode,
        "data" => json_decode($response, true)
    ]);
}