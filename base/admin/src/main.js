import Vue from 'vue/dist/vue.esm.js';
import VueRouter from 'vue-router';
import axios from 'axios';

import App from './App.vue';
import SideLeft from './components/SideLeft.vue';
import SideRight from './components/SideRight.vue';

import store from './store.js';
import router from './router.js';


/**
 * Initiate VUE instance
 */

new Vue({
	el: '#app',
	store,
	router,
	template: '<app />',
	components: { App }
})