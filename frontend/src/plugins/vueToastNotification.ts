import {createApp} from 'vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const app = createApp({});
app.use(ToastPlugin);
app.mount('#app');
