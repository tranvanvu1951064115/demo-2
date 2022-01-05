export const $ = document.querySelector.bind(document);
export const $$ = document.querySelectorAll.bind(document);
export const signUpInputs = $$('.sign.form input:not(input[type="checkbox"])');
export const submitSignFormBtn = $('.form-btn-sign');
export const loginInput = $$('.login input:not([type="checkbox"])');
export const sidebarLink = $$('.l-sidebar__link');

