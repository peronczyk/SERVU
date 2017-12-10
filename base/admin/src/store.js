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
		appVersion: null,
		toast: {
			isVisible: false,
			content: null
		},
		modal: {
			isOpen: false,
			content: null
		}
	},


	/** ----------------------------------------------------------------------------
	 * Getters
	 */

	getters: {
		isAppConnected(state) {
			return state.connected;
		},

		getUserAccess(state) {
			return state.userAccessLvl;
		},
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

		setAppVersion(state, version) {
			state.appVersion = version;
		},

		openToast(state, content) {
			state.toast.isVisible = !state.toast.isVisible;
			state.toast.content = content;
		},

		closeToast(state) {
			state.toast.isVisible = false;
			setTimeout(() => {
				state.toast.content = null;
			});
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
		}
	},


	/** ----------------------------------------------------------------------------
	 * Actions
	 */

	actions: {
	}
});