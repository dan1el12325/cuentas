import { banksList, brandsList, cardsTypeList } from "./constants.js";

export const parseCardNumber = (cardNumber) => {
    return {
        bin: cardNumber.slice(0, 6),
        last4: cardNumber.slice(-4)
    };
};

export const detectBank = (bankName) => {
    const name = bankName.toLowerCase();

    const key = Object.keys(banksList).find(k =>
        name.includes(k)
    );

    return banksList[key];
};

export const detectBrand = (brandName) => {
    const name = brandName.toLowerCase();

    const key = Object.keys(brandsList).find(k =>
        name.includes(k)
    );

    return brandsList[key];
};

export const detectCardType = (cardType) => {
    const type = cardType.toLowerCase();

    const key = Object.keys(cardsTypeList).find(k => 
        type.includes(k)
    );

    return cardsTypeList[key];
}