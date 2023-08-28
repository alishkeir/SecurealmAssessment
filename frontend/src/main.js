import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import EventBus from './bus';
import store from './store';

import API from './api';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import './plugins/font-awesome';

import cookie from 'js-cookie';

import 'bootstrap/dist/css/bootstrap.min.css';

const app = createApp(App);

app.config.globalProperties.$http = API;
app.config.globalProperties.$route = router;
app.config.globalProperties.$bus = EventBus;
app.config.globalProperties.$cookie = cookie;
app.config.globalProperties.$store = store;

app
  .use(router)
  .use(store)
  .component('font-awesome-icon', FontAwesomeIcon)
  .mount('#app');

import 'bootstrap/dist/js/bootstrap.min.js';
