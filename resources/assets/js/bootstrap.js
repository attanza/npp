
window._ = require('lodash');
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.Noty = require('noty');
// Noty.overrideDefaults({
//   layout: 'topCenter',
//   theme: 'metroui',
//   timeout: 5000,
//   progressBar: true,
// });
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key : "d721fdf1882ec59b280f",
    cluster: 'ap1',
    encrypted: true,
});
// 
// Pusher.log = function(message){
//     window.console.log(message)
// }
