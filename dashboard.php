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

            <div class="modal-cards hidden">
                <h2>NO HAY TARJETAS REGISTRADAS</h2>
                <p>Para comenzar registra alguna tarjeta</p>
                <button>Registrar Nueva Tarjeta</button>
            </div>
        </div>
        <div class="transactions-container"></div>
    </div>

    <div class="modal-new-card">
        <h2>NUEVA TARJETA</h2>
        <form action="" class="new-card-form">
            <p>NUMERO DE TARJETA</p>
            <input type="text" id="card-number" placeholder="XXXX-XXXX-XXXX-XXXX">
            <p>Institución Bancaria</p>
            <input type="text" name="bank" id="bank">
            <p>Marca</p>
            <input type="text" name="brand" placeholder="VISA, MASTERCARD..." id="brand">
            <p>Alias de Tarjeta</p>
            <input type="text" name="alias">
            <p>Tipo de tarjeta</p>
            <select name="card-type" id="card-type">
                <option value="debit">DEBITO</option>
                <option value="credit">CREDITO</option>
            </select>
            <p>Límite de Crédito</p>
            <input type="number">
            <p>Fecha de Corte</p>
            <input type="number" name="fechaCorte" min="1" max="31" placeholder="DIA DE CORTE...">
            <p>Fecha de Pago</p>
            <input type="number" name="fechaPago" min="1" max="31" placeholder="DIA DE PAGO...">
            <button type="submit">REGISTRAR TARJETA</button>
        </form>
    </div>
</body>
<script>
    const cardsContainer = document.querySelector(".cards-container");
    const modalCards = document.querySelector(".modal-cards");
    const cardNumber = document.getElementById("card-number");
    const brand = document.getElementById("brand");
    const cardType = document.getElementById("card-type");
    const bank = document.getElementById("bank");

    const banksList = {
        bbva: "BBVA",
        banorte: "Banorte",
        santander: "Santander",
        hsbc: "HSBC",
        banamex: "BANAMEX",
        scotiabank: "Scotiabank",
        azteca: "Banco Azteca",
        inbursa: "Inbursa"
    }

    const brandsList = {
        visa: "VISA",
        mastercard: "MASTERCARD",
        amex: "AMERICAN EXPRESS",
        discover: "DISCOVER"
    }

    const getCards = async () => {
        try{
            const response = await fetch("cards/getCards.php");
            const data = await response.json();
            console.log(data);
            if(data.success === false){
                modalCards.classList.remove("hidden");
            }
        }catch(err){
            console.error('Ups! Something went wrong ', err.message);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        getCards();
    });

    const getCardInfo = async (cardNumber) => {
        const bin = cardNumber.slice(0, 6);
        const last4 = cardNumber.slice(-4);
        
        try{
            console.log("Buscando BIN")
            const response = await fetch(`cards/getCardInfo.php?cardBin=${bin}`);
            const data = await response.json();
            if(data.http === 200){
                console.log("Exito en la consulta");
                const bankName = data.data.bank.name.toLowerCase();
                const bankKey = Object.keys(banksList).find(key => 
                    bankName.includes(key)
                );

                const brandName = data.data.brand.toLowerCase();
                const brandKey = Object.keys(brandsList).find(key => 
                    brandName.includes(key)
                );

                bank.value = banksList[bankKey];
                brand.value = brandsList[brandKey];
                cardType.value = data.data.type;


            }else{
                console.log("Error HTTP: ", data.http);
            }
        }catch(err){
            console.error("Ups! Something went wrong ", err.message);
        }
    }

    cardNumber.addEventListener("change", () => {
        getCardInfo(cardNumber.value);
    })

</script>
</html>