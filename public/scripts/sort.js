document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("monsterSearch");
    const monsterCards = document.querySelectorAll(".monster-card");

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();

        monsterCards.forEach(card => {
            const monsterName = card.dataset.name;

            card.style.display =
                monsterName.includes(query) ? "" : "none";
        });
    });

    const sortButton = document.getElementById("sortButton");
    const sortMenu = document.getElementById("sortMenu");
    const monsterGrid = document.getElementById("monsterGrid");

    sortButton.addEventListener("click", () => {
        sortMenu.classList.toggle("active");
    });

    document.querySelectorAll("#sortMenu button").forEach(button => {
        button.addEventListener("click", () => {

            const sortType = button.dataset.sort;

            const cards = [...document.querySelectorAll(".monster-card")];

            cards.sort((a, b) => {

                switch (sortType) {

                    case "rating":
                        return parseFloat(b.dataset.rating) -
                               parseFloat(a.dataset.rating);

                    case "sweetness":
                        return parseFloat(b.dataset.sweetness) -
                               parseFloat(a.dataset.sweetness);

                    case "sourness":
                        return parseFloat(b.dataset.sourness) -
                               parseFloat(a.dataset.sourness);

                    case "carbonation":
                        return parseFloat(b.dataset.carbonation) -
                               parseFloat(a.dataset.carbonation);

                    case "energy":
                        return parseFloat(b.dataset.energy) -
                               parseFloat(a.dataset.energy);

                    case "name":
                        return a.dataset.name.localeCompare(b.dataset.name);

                    default:
                        return 0;
                }
            });

            cards.forEach(card => monsterGrid.appendChild(card));

            sortMenu.classList.remove("active");
        });
    });
});