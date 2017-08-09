require('./bootstrap');

window.Vue = require('vue');
// Bulma Vue - Buefy
import Buefy from 'buefy'
Vue.use(Buefy)
Vue.component('login-register', require('./components/auth/LoginRegister.vue'));

const app = new Vue({
    el: '#app'
});
