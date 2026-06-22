export const noExpenses = (card) => {
    const div = document.createElement("div");
    const h2 = document.createElement("h2");
    const p = document.createElement("p");

    h2.textContent = card ? "No se encontraron gastos registrados en esta tarjeta" : "No se encontraron gastos registrados";

    p.textContent = "Para comenzar registra un gasto"

    div.appendChild(h2);
    div.appendChild(p);

    div.classList.add("expenses-list");

    return div;
}