const cardsList = document.querySelector(".cards-list");//CONTENEDOR DE LISTA DE TARJETAS
const cardsContainer = document.querySelector(".cards-container");//CONTENEDOR PRINCIPAL DE LAS TARJETAS

import { loadCards } from "./api/cardsApi.js";
import { renderCards } from "./modules/cards/renderCards.js";
import { initCardModals } from "./modules/modals/newCardModal.js";
import { handleExpensesRender, initCardsEvents } from "./modules/cards/cardsEvents.js";

document.addEventListener("DOMContentLoaded", async () => {
    const result = await loadCards();
    renderCards(cardsList, result);
    handleExpensesRender();
    initCardsEvents(cardsContainer);
    initCardModals(cardsContainer);
});

//usar try...catch para posibles errores