

export const loadExpenses = async (cardId = null) => {
    try {
        const url = cardId ? `expenses/getExpenses.php?card-id=${cardId}` : 'expenses/getExpenses.php';
        const response = await fetch(url);
        const data = await response.text();
        return data;
    } catch (err) {
        console.error("Ups! Something went wrong ", err.message);
    }
}