import { detectBank, detectBrand, detectCardType, parseCardNumber } from "../../utils/cardParser.js";
import { getCardInfo} from "../../api/cardsApi.js";

const bank = document.getElementById("bank");
const brand = document.getElementById("brand");
const cardType = document.getElementById("card-type");

export const handleGetCardInfo = async (cardNumber) => {
    const { bin, last4 } = parseCardNumber(cardNumber);

    try {
        const data = await getCardInfo(bin);

        if (data.http !== 200) return;

        bank.value = detectBank(data.data.bank.name);
        brand.value = detectBrand(data.data.brand);
        cardType.value = detectCardType(data.data.type);

    } catch (err) {
        console.error(err.message);
    }
};

//pasar variables como parametros