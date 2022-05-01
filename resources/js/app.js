require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('create-chat-button', require('./components/CreateChatButton.vue').default);

import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'
Vue.use(Vuex)
const axios = require('axios').default;

const app = new Vue({
    el: '#app',
    store
});
