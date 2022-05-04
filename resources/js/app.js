require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('create-chat-button', require('./components/CreateChatButton.vue').default);
Vue.component('chat-list', require('./components/ChatList.vue').default);
Vue.component('public-header', require('./components/PublicHeader.vue').default);
Vue.component('messages-list', require('./components/MessagesList.vue').default);

import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'
Vue.use(Vuex)
const axios = require('axios').default;
axios.defaults.headers.common = {
    "X-Requested-With": "Axios",
};

const app = new Vue({
    el: '#app',
    store
});
