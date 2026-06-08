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

            <div class="no-cards-modal hidden">
                <h2>NO HAY TARJETAS REGISTRADAS</h2>
                <p>Para comenzar registra alguna tarjeta</p>
                <button>Registrar Nueva Tarjeta</button>
            </div>
        </div>
        <div class="transactions-container"></div>
    </div>

    <div class="modal-new-card hidden">
        <h2>NUEVA TARJETA</h2>
        <form action="" class="new-card-form">
            <p>NUMERO DE TARJETA</p>
            <input type="text" id="card-number" placeholder="XXXX-XXXX-XXXX-XXXX">
            <p>Institución Bancaria</p>
            <input type="text" name="bank" id="bank" placeholder="BBVA, SANTANDER...">
            <p>Marca</p>
            <input type="text" name="brand" placeholder="VISA, MASTERCARD..." id="brand">
            <p>Alias de Tarjeta</p>
            <input type="text" name="alias">
            <p>Tipo de tarjeta</p>
            <select name="card-type" id="card-type">
                <option value="debito">DEBITO</option>
                <option value="credito">CREDITO</option>
            </select>
            <p>Límite de Crédito</p>
            <input type="number" id="credit-limit" name="credit-limit">
            <p>Fecha de Corte</p>
            <input type="number" name="closing-date" min="1" max="31" placeholder="DIA DE CORTE..." id="closing-date">
            <p>Fecha de Pago</p>
            <input type="number" name="due-date" min="1" max="31" placeholder="DIA DE PAGO..." id="due-date">
            <button type="submit">REGISTRAR TARJETA</button>
        </form>
    </div>
</body>
<script>
    const cardsContainer = document.querySelector(".cards-container");
    const modalCards = document.querySelector(".no-cards-modal");
    const cardNumber = document.getElementById("card-number");
    const brand = document.getElementById("brand");
    const cardType = document.getElementById("card-type");
    const bank = document.getElementById("bank");
    const closingDate = document.getElementById("closing-date");
    const dueDate = document.getElementById("due-date");
    const creditLimit = document.getElementById("credit-limit");
    const newCardForm = document.querySelector(".new-card-form");

    document.addEventListener("DOMContentLoaded", () => {
        getCards();
        toggleCreditFields(cardType);
    });

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

    const banksImageList = {
        BBVA: "bbva.svg"
    }

    const brandsImageList = {
        VISA: "visa.svg"
    }

    const getBankImages = (text) => {
        const imageKey = Object.keys(banksImageList).find(key => 
            text.includes(key)
        );
        return imageKey;
    }

    const getBrandImages = (text) => {
        const imageKey = Object.keys(brandsImageList).find(key => 
            text.includes(text)
        );
        return imageKey;
    }

    const getCards = async () => {
        try{
            const response = await fetch("cards/getCards.php");
            const data = await response.json();
            const dataArr = data.data;
            console.log(data.data);
            if(data.success === true){
                cardsContainer.innerHTML = '';
                dataArr.forEach((card) => {
                    const bank = getBankImages(card.banco);
                    const brand = getBrandImages(card.marca);
                    const cardElement = document.createElement("div");
                    cardElement.classList.add("card");
                    cardElement.innerHTML = `
                        <div class="card-top">
                            <img src="assets/icons/payment/${banksImageList[bank]}"/>
                        </div>
                        <div class="card-chip">
                            <img src="assets/icons/payment/chip2.svg"/>
                        </div>
                        <div class="card-info"><p>**** **** **** ${card.ultimos4}</p></div>
                        <div class="card-footer">
                            <div class="card-owner"><p>${card.nombre}</p></div>
                            <div class="card-brand">
                                <img src="assets/icons/payment/${brandsImageList[brand]}" />
                            </div>
                        </div>`;

                    cardsContainer.appendChild(cardElement);
                });
            }else{
                modalCards.classList.remove("hidden");
            }
        }catch(err){
            console.error('Ups! Something went wrong ', err.message);
        }
    }

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
    });

    const toggleCreditFields = (cardType) => {
        const isDebit = cardType.value === 'debito';
        closingDate.disabled = isDebit;
        dueDate.disabled = isDebit;
        creditLimit.disabled = isDebit;
    }

    cardType.addEventListener("change", () => {

    });

    const saveCard = async () => {
        const formData = new FormData(newCardForm);
        const bin = cardNumber.value.slice(0, 6);
        const last4 = cardNumber.value.slice(-4);
        formData.append("bin", bin);
        formData.append("last4", last4);

        try{
            const response = await fetch("cards/saveCard.php", {
                method: "POST",
                body: formData
            });
            const data = await response.text();
            console.log(data);
        }catch(err){
            console.error('Ups! Something went wrong ', err.message);
        }
    }

    newCardForm.addEventListener("submit", (e) => {
        e.preventDefault();
        saveCard();
    });

</script>
</html>