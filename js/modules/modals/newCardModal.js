const closeBtn = document.querySelector(".close-btn");
const addNewCard = document.getElementById("add-new-card-btn");
const cardNumber = document.getElementById("card-number");//INPUT NUMERO DE TARJETA
const cardType = document.getElementById("card-type");//SELECT TIPO DE TARJETA
const newCardForm = document.querySelector(".new-card-form");//FORMULARIO PARA AGREGAR NUEVA TARJETA
const closingDate = document.getElementById("closing-date");//INPUT DE FECHA DE CORTE DE TARJETA
const creditLimit = document.getElementById("credit-limit");//INPUT CREDITO LIMITE DE LA TARJETA
const dueDate = document.getElementById("due-date");//INPUT DE FECHA LIMITE DE PAGO DE TARJETA
const modalNewCardForm = document.querySelector (".modal-new-card-form");

import { handleGetCardInfo } from "../cards/cardsForm.js";
import { saveCard } from "../../api/cardsApi.js";
import { parseCardNumber } from "../../utils/cardParser.js";

const globalbin = '';
const globallast4 = '';

export const openModal = (modal) => {
    modal.classList.remove ("hidden");
}

export const closeModal = (modal) => {
    modal.classList.add("hidden");
}

export const initCardModals = (container) => {
    container.addEventListener("click", (e) => {
        const button = e.target.closest(".new-card, #add-new-card-btn");
        if(!button) return ;
        openModal(modalNewCardForm);
    });

    toggleCreditFields(cardType);
    cardType?.addEventListener("change", () => toggleCreditFields(cardType));

    closeBtn.addEventListener("click", () => closeModal(modalNewCardForm));

    cardNumber?.addEventListener("change", () => {
        handleGetCardInfo(cardNumber.value)
    });

    newCardForm?.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(newCardForm);

    const { bin, last4 } = parseCardNumber(cardNumber.value);

    formData.append("bin", bin);
    formData.append("last4", last4);

    saveCard(formData);
    });
}

const toggleCreditFields = (cardType) => {
    const isDebit = cardType.value === 'debito';
    closingDate.disabled = isDebit;
    dueDate.disabled = isDebit;
    creditLimit.disabled = isDebit;
}