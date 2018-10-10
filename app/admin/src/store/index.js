// Dependencies
import Vue from 'vue/dist/vue.esm.js';
import Vuex from 'vuex';

// Modules
import base from './base';
import collections from './collections';
import content from './content';
import modal from './modal';
import optionsmenu from './optionsmenu';
import user from './user';
import toast from './toast';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		base,
		collections,
		content,
		modal,
		optionsmenu,
		user,
		toast,
	}
});