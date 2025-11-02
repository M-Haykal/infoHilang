import './bootstrap';
import Echo from 'laravel-echo';
import Alpine from 'alpinejs';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Alpine = Alpine;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

Alpine.start();
