import Vue from 'vue/dist/vue.esm.js';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({

	/** ----------------------------------------------------------------------------
	 * State
	 */

	state: {
		connected: false,
		userAccessLvl: 0,
		meta: {
			appVersion: null,
			phpVersion: null,
		},
		toast: {
			isVisible: false,
			content: null
		},
		modal: {
			isOpen: false,
			content: null
		},
		optionsMenu: {
			isOpen: false,
		},
		contentFieldTypes: [
			{
				id: 'simple',
				name: 'Simple text field'
			},
			{
				id: 'rich',
				name: 'Rich text field'
			},
		],
	},


	/** ----------------------------------------------------------------------------
	 * Getters
	 */

	getters: {
		isAppConnected    : state => state.connected,
		getUserAccess     : state => state.userAccessLvl,
		isOptionsMenuOpen : state => state.optionsMenu.isOpen,
		isToastVisible    : state => state.toast.isVisible,
		getToastContent   : state => state.toast.content,
	},


	/** ----------------------------------------------------------------------------
	 * Mutations
	 */

	mutations: {
		appConnected(state, meta) {
			state.connected = true;
			state.userAccessLvl = meta['access-lvl'];
		},

		changeUserAccessLvl(state, lvl) {
			state.userAccessLvl = lvl;
		},

		setMeta(state, meta) {
			state.meta.appVersion = meta['app-version'];
			state.meta.phpVersion = meta['php-version'];
		},

		openToast(state, content) {
			state.toast.isVisible = !state.toast.isVisible;
			state.toast.content = content;
		},

		closeToast(state) {
			state.toast.isVisible = false;
			setTimeout(() => {
				state.toast.content = null;
			}, 500);
		},

		openModal(state, content) {
			state.modal.isOpen = true;
			state.modal.content = content;
		},

		closeModal(state) {
			state.modal.isOpen = false;
			setTimeout(() => {
				state.modal.content = null;
			}, 1000);
		},

		setOptionsMenuState(state, value) {
			state.optionsMenu.isOpen = value;
		}
	},


	/** ----------------------------------------------------------------------------
	 * Actions
	 */

	actions: {
	}
});