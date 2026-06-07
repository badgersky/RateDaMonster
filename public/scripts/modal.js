function openModal(button) {
    const modal = document.getElementById('monsterModal');
    
    document.getElementById('modalName').textContent = button.dataset.name;
    document.getElementById('modalImg').src = button.dataset.img;
    document.getElementById('modalImg').alt = button.dataset.name;
    document.getElementById('modalDesc').textContent = button.dataset.desc;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('monsterModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

window.onclick = function(event) {
    const modal = document.getElementById('monsterModal');
    if (event.target == modal) {
        closeModal();
    }
}