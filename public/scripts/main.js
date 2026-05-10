function toggleDescription(id, btn) {
    const desc = document.getElementById('desc-' + id);
    
    if (desc.classList.contains('collapsed')) {
        desc.classList.remove('collapsed');
        btn.textContent = 'Opis -';
    } else {
        desc.classList.add('collapsed');
        btn.textContent = 'Opis +';
    }
}