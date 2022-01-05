import {$, $$, loginInput} from '../variables.js';
[...loginInput].forEach(input=>{
    // LABEL TRONG FORMGROUP
    const label = input.previousElementSibling;
    if(input.id == 'password') {
        label.style.paddingBottom = '25px';
        label.setAttribute('data-error', "Password is incorect");
    }

    // KHI FOCUS THÌ LOẠI BỎ LỖI
    input.addEventListener('focus', () => {
        label.style.paddingBottom = '10px';
        label.setAttribute('data-error', "");
    })
})