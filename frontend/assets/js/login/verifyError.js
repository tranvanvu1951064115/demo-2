import {$, $$, loginInput} from '../variables.js';
const  formTitle = $('.login .form-title');
formTitle.querySelector('a.errorEmail').innerHTML = "Please verify your information before logging in";
// [...loginInput].forEach(input => {
//     // KHI FOCUS THÌ LOẠI BỎ LỖI
//     input.addEventListener('focus', () => {
//         formTitle.innerHTML = "Login to Twitter";
//     })
// })

