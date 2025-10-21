const openEditButtons = document.querySelectorAll('[data-edit-target]');
const closeEditButtons = document.querySelectorAll('[data-close-button]');
const overlay = document.getElementById('overlay');
// Open edit modal
openEditButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.editTarget);
        openModal(modal);
    });
});
// Close modal
closeEditButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        closeModal(modal);
    });
});
// Close on overlay click
overlay.addEventListener('click', () => {
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach(modal => closeModal(modal));
});
function openModal(modal) {
    if (modal == null) return;
    modal.classList.add('active');
    overlay.classList.add('active');
}
function closeModal(modal) {
    if (modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
}