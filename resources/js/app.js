require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('public-header', require('./components/PublicHeader.vue').default);

import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'
Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    store
});
