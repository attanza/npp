require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue({})

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
Vue.component('notification-list', require('./components/notifications/NotificationList.vue'));

// User
Vue.component('user-init', require('./components/user/UserInit.vue'));

// Profile
Vue.component('profile-info', require('./components/profile/ProfileInfo.vue'));
Vue.component('avatar', require('./components/profile/avatar/Avatar.vue'));
Vue.component('avatar-upload', require('./components/profile/avatar/AvatarUpload.vue'));


// nav
Vue.component('avatar-nav', require('./components/profile/avatar/AvatarNav.vue'));
Vue.component('mobile-nav', require('./components/nav/MobileNav.vue'));
Vue.component('unread-nots', require('./components/nav/UnreadNots.vue'));
// Vue.component('main-nav', require('./components/nav/MainNav.vue'));

// dream
Vue.component('dream', require('./components/dream/Dream.vue'));
Vue.component('dream-list', require('./components/dream/DreamList.vue'));
Vue.component('dream-photo', require('./components/dream/DreamPhoto.vue'));
// Vue.component('dream-redirector', require('./components/dream/DreamRedirector.vue'));
Vue.component('dream-counter', require('./components/dream/DreamCounter.vue'));
Vue.component('dream-create-form', require('./components/dream/DreamCreateForm.vue'));

// comments
Vue.component('dream-comments', require('./components/dream_comments/controllers/DreamComments.vue'));

// Orders
Vue.component('order-form', require('./components/orders/OrderForm.vue'));

// Boost
Vue.component('boost', require('./components/boost/Boost.vue'));
import {
  store
} from './store'
const app = new Vue({
    el: '#app',
    store
});
