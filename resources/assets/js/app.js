require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue({})

// Bulma Vue - Buefy
import Buefy from 'buefy';
Vue.use(Buefy);

// Auth
Vue.component('login-register', require('./components/auth/LoginRegister.vue'));
Vue.component('login', require('./components/auth/Login.vue'));
// Nav
Vue.component('user-menu', require('./components/nav/UserMenu.vue'));


const app = new Vue({
    el: '#app'
});
