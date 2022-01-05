const dataSignUp = localStorage.getItem("localSignUp");
if(dataSignUp) {
    const rememberBtn = document.querySelector('#check[name="remember"]');
    rememberBtn.checked = true;
    
    const formSign = document.querySelector('.form-signup-main');
    const arrInput = JSON.parse(dataSignUp);
    arrInput.forEach(input => {
        formSign.querySelector(`input[name = "${input.name}"]`).value = input.value;
    });
}
