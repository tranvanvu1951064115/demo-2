// XỬ LÝ LẤY DỮ LIỆU
const rememberBtn = document.querySelector('#check[name="remember"]');
const formLog = document.querySelector('.form-log-main');
const dataLogIn = localStorage.getItem("localLogIn");

if(dataLogIn) {
    const rememberBtn = document.querySelector('#check[name="remember"]');
    rememberBtn.checked = true;
    const arrInput = JSON.parse(dataLogIn);
    arrInput.forEach(input => {
        formLog.querySelector(`input[name = "${input.name}"]`).value = input.value;
    });
}

// XỬ LÝ LƯU TRỮ
formLog.onsubmit = function(e) {
    if(rememberBtn.checked) {
        let arrInput = [];
        [...formLog.querySelectorAll('input:not(input[type="checkbox"])')].forEach(input => {
            arrInput.push({
            name: input.name,
            value: input.value
            })
        })
        arrInput = JSON.stringify(arrInput);
        localStorage.setItem("localLogIn", arrInput);
    } else {
        localStorage.removeItem("localLogIn");
    }
}



