document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("monsterSearch");
    const rows = document.querySelectorAll(".admin-table tbody tr");

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();

        rows.forEach(row => {
            const nameCell = row.children[1];
            const name = nameCell.textContent.toLowerCase();

            if (name.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});