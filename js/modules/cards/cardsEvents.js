import { getExpenses } from "../../api/expensesApi.js";

export const initCardsEvents = (container) => {
    if(!container) return;

    container.addEventListener("click", (e) => {
        const card = e.target.closest(".card, .new-card");

        if(!card) return;

        card.scrollIntoView({
            behavior: "smooth",
            inline: "center"
        });

        getExpenses(card.dataset.id);

    })
}