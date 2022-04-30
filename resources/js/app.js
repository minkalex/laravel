require('./bootstrap');
import bootstrap from 'bootstrap'

window.Vue = require('vue').default;
const axios = require('axios').default;

//Vue.component('public-header', require('./components/PublicHeader.vue').default);
Vue.component('create-chat-button', require('./components/CreateChatButton.vue').default);

import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'
Vue.use(Vuex)

/*const app = new Vue({
    el: '#app',
    store
});*/

const app = new Vue({
    el: '#app',
});

axios.get('/user?ID=12345')
    .then(function (response) {
        // handle success
        console.log(response);
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    .then(function () {
        // always executed
    });
