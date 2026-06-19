const bank = document.getElementById("bank");//INPUT BANCO DE LA TARJETA
const brand = document.getElementById("brand");//INPUT MARCA DE LA TARJETA 
const cardType = document.getElementById("card-type");//SELECT TIPO DE TARJETA
import { banksList, brandsList } from "../utils/constants.js";

export const loadCards = async (cardId = null) => {
    try {
        const url = cardId ? `cards/getCards.php?cardId=${cardId}` : `cards/getCards.php` ;
        const response = await fetch(url);
        const data = await response.json();
        if(Array.isArray(data)) return data;
        return data?.data ?? data;
    } catch (err) {
        console.error("Ups! Something went wrong ", err.message);
    }
}

export const getCardInfo = async (bin) => {
    try {
        const response = await fetch(`cards/getCardInfo.php?cardBin=${bin}`);
        const data = await response.json();
        return data;
    } catch (err) {
        console.error("Ups! Something went wrong ", err.message);
    }
}

export const saveCard = async (formData) => {
    try {
        const response = await fetch("cards/saveCard.php", {
            method: "POST",
            body: formData
        })
        const data = await response.text();
        console.log(data);
    } catch (err) {
        console.error("Ups! Something went wrong ", err.message);
    }
}