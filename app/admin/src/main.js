import './assets/styles/styles.scss';

import Vue from 'vue/dist/vue.esm.js';
import App from './App.vue';

import store from './store/';
import router from './router.js';


/** --------------------------------------------------------------------------------
 * Custom directives
 */

import './directives/ClickOutside.js';


/** --------------------------------------------------------------------------------
 * Global components
 */

import Icon from './components/elements/Icon.vue';
Vue.component('Icon', Icon);



/** --------------------------------------------------------------------------------
 * Initiate VUE instance
 */

window.servuAdminApp = new Vue({
	el: '#app',
	store,
	router,
	template: '<app />',
	components: { App }
})