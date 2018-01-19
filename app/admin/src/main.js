import styles from './assets/styles/styles.scss';

import Vue from 'vue/dist/vue.esm.js';
import VueRouter from 'vue-router';

import App from './App.vue';

import store from './store.js';
import router from './router.js';


/**
 * Global components
 */

import Icon from './components/elements/Icon.vue';

Vue.component('Icon', Icon);


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