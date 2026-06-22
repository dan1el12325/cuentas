import { loadExpenses } from "../../api/expensesApi.js";
import { noExpenses } from "../expenses/renderExpenses.js";
const expensesContainer = document.querySelector(".expenses-container");

export const initCardsEvents = (container) => {
    if(!container) return;

    container.addEventListener("click", async (e) => {
        const card = e.target.closest(".card, .new-card");

        if(!card) return;

        card.scrollIntoView({
            behavior: "smooth",
            inline: "center"
        });

        handleExpensesRender(card.dataset.id);
    })
}

export const handleExpensesRender = async (cardId = null) => {
    expensesContainer.innerHTML = '';
    const data = await loadExpenses(cardId);
    let div = '';

    if(!data.data){
        div = await noExpenses(cardId);
    }

    expensesContainer.appendChild(div);

}