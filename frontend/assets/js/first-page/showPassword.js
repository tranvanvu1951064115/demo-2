const showPassButton = document.querySelector("#showPassword");
showPassButton.onclick = () => {
    showPassButton.classList.toggle('active');
    const isActive = showPassButton.classList.contains('active');
    const passwordInputs = document.querySelectorAll('input[name*="password"]');
    if(isActive) {
        [...passwordInputs].forEach(input => {
            input.type = 'text';
        })
    } else {
        [...passwordInputs].forEach(input => {
            input.type = 'password';
        })
    }
}
