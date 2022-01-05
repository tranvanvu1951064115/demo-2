import {$,$$} from '../variables.js';
const user = $('.user');
const userLogoutDiv = $('.user-logout-wrapper');
const userLogoutMain = $('.user-logout-main');
user.onclick = function(e) {
    userLogoutDiv.classList.toggle('active');
}
userLogoutDiv.onclick = function(e) {
    this.classList.remove('active');
}