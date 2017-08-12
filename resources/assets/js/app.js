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

// Main
Vue.component('session-messages', require('./components/SessionMessages.vue'));

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

import {
  store
} from './store'
const app = new Vue({
    el: '#app',
    store
});
