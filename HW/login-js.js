function onFocus(e) {
    // Seleziono l'icona associata al campo del form che si trova in focus
    const icon = e.currentTarget.parentNode.querySelectorAll('.focus-input::after');

    icon.classList.add('.active-input');

    e.addEventListener('blur', onLostFocus);
    e.removeEventListener('focus', onFocus);
}

function onLostFocus(e) {
    const icon = e.currentTarget.parentNode.querySelectorAll('.focus-input::after');

    icon.classList.remove('.active-input');

    e.addEventListener('focus', onFocus);
    e.removeEventListener('blur', onLostFocus);
}

const inputs = document.querySelectorAll('.wrap-input label');

for (const input of inputs) {
    input.addEventListener('focus', onFocus);
}