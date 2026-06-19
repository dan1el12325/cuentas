import { banksImageList, brandsImageList } from "../../utils/constants.js"
import { getBankImages, getBrandImages } from "../../utils/cardHelpers.js"

export const createCardElement = (card) => {
    const bank = getBankImages(card.banco);
        const brand = getBrandImages(card.marca);
        const cardElement = document.createElement("div");
        cardElement.classList.add("card");
        cardElement.dataset.id = `${card.id_tarjeta}`;
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
    return cardElement;
}
