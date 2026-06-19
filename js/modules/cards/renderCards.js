import { createCardElement } from "./cardTemplate.js";
const newCard = document.querySelector(".new-card");//BOTON PARA AGREGAR NUEVA TERJETA
const modalCards = document.querySelector(".no-cards-modal");//MODAL CUANDO NO HAY TARJETAS

export const renderCards = (container, cardsList) => {
    if(!cardsList || cardsList.success === false){
        newCard.classList.add("hidden");
        modalCards.classList.remove("hidden");
        return;
    }
    
    container.innerHTML = '';

    modalCards.classList.add("hidden");

    const fragment = document.createDocumentFragment();
    cardsList.forEach(card => fragment.appendChild(createCardElement(card)));
    container.appendChild(fragment);
    newCard.classList.remove("hidden");
}

//fragment es para crear un contenedor temporal en memoria donde se pueden agregar nodos html antes de insetrarlos en el DOM real.