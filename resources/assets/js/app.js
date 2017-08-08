require('./bootstrap');

window.Vue = require('vue');
// Bulma Vue - Buefy
// import Buefy from 'buefy'
// Vue.use(Buefy)
Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
