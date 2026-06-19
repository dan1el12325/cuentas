<?php

session_start();

if(!isset($_SESSION['username'])){
    header('Location: index.html');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include 'includes/sidebar.php';?>

    <div class="content">

        <div class="cards-container">

            <div class="cards-list">
                <div class="no-cards-modal hidden">
                    <h2>NO HAY TARJETAS REGISTRADAS</h2>
                    <p>Para comenzar registra alguna tarjeta</p>
                    <button id="add-new-card-btn">Registrar Nueva Tarjeta</button>
                </div>
            </div>

            <div class="new-card hidden">
                <img src="assets/icons/payment/plus.svg">
            </div>
        </div>

        <div class="transactions-container"></div>

    </div>

    <div class="modal-new-card-form hidden">

        <button class="close-btn">X</button>

        <h2>NUEVA TARJETA</h2>

        <form action="" class="new-card-form">

            <p>NUMERO DE TARJETA</p>
            <input type="text" id="card-number" placeholder="XXXX-XXXX-XXXX-XXXX" required>
            <p>Institución Bancaria</p>
            <input type="text" name="bank" id="bank" placeholder="BBVA, SANTANDER..." required>
            <p>Marca</p>
            <input type="text" name="brand" placeholder="VISA, MASTERCARD..." id="brand" required>
            <p>Alias de Tarjeta</p>
            <input type="text" name="alias" required>
            <p>Tipo de tarjeta</p>

            <select name="card-type" id="card-type">
                <option value="debito">DEBITO</option>
                <option value="credito">CREDITO</option>
            </select>

            <p>Límite de Crédito</p>
            <input type="number" id="credit-limit" name="credit-limit" required>
            <p>Fecha de Corte</p>
            <input type="number" name="closing-date" min="1" max="31" placeholder="DIA DE CORTE..." id="closing-date" required>
            <p>Fecha de Pago</p>
            <input type="number" name="due-date" min="1" max="31" placeholder="DIA DE PAGO..." id="due-date" required>

            <button type="submit">REGISTRAR TARJETA</button>

        </form>

    </div>
</body>
<script type="module" src="js/dashboard.js"></script>
</html>
