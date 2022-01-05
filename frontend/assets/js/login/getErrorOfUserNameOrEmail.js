import {loginInput} from '../variables.js';

[...loginInput].forEach(input=>{
    // LABEL TRONG FORMGROUP
    const label = input.previousElementSibling;
    if(input.id == 'userOrEmail') {
        label.style.paddingBottom = '25px';
        label.setAttribute('data-error', "Username or Email is incorect");
    }

    // KHI FOCUS THÌ LOẠI BỎ LỖI
    input.addEventListener('focus', () => {
        label.style.paddingBottom = '10px';
        label.setAttribute('data-error', "");
    })
})