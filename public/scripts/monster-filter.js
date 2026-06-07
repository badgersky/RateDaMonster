document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("monsterSearch");
    const monsterCards = document.querySelectorAll(".monster-card");

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();

        monsterCards.forEach(card => {
            const monsterName = card.dataset.name;

            if (monsterName.includes(query)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
});