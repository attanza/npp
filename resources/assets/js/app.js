require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue({})

// Bulma Vue - Buefy
import Buefy from 'buefy';
Vue.use(Buefy);
// Moment
import moment from 'moment';
import 'moment/locale/id';
import VueMoment from 'vue-moment';
Vue.use(VueMoment);

// Vue scroll
import VueScrollto from 'vue-scrollto';
Vue.use(VueScrollto);

// Main
Vue.component('session-messages', require('./components/SessionMessages.vue'));

// Admin
require('./admin_components');


// Auth
Vue.component('register', require('./components/auth/Register.vue'));
Vue.component('login', require('./components/auth/Login.vue'));

// Notifications
Vue.component('notification-listener', require('./components/notifications/NotificationListener.vue'));

// User
Vue.component('user-init', require('./components/user/UserInit.vue'));

// Profile
Vue.component('profile-info', require('./components/profile/ProfileInfo.vue'));
Vue.component('avatar', require('./components/profile/avatar/Avatar.vue'));

// nav
Vue.component('avatar-nav', require('./components/profile/avatar/AvatarNav.vue'));
Vue.component('mobile-nav', require('./components/nav/MobileNav.vue'));
Vue.component('unread-nots', require('./components/nav/UnreadNots.vue'));


// dream
Vue.component('dream', require('./components/dream/Dream.vue'));
Vue.component('dream-list', require('./components/dream/DreamList.vue'));
Vue.component('dream-photo', require('./components/dream/show/DreamPhoto.vue'));
Vue.component('dream-redirector', require('./components/dream/DreamRedirector.vue'));

// comments
Vue.component('dream-comments', require('./components/dream/show/DreamComments.vue'));

// Orders
Vue.component('order-form', require('./components/orders/OrderForm.vue'));


import {
  store
} from './store'
const app = new Vue({
    el: '#app',
    store
});
