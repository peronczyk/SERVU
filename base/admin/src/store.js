import Vue from 'vue/dist/vue.esm.js';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({

	/** ----------------------------------------------------------------------------
	 * State
	 */

	state: {
		connected: false,
		userAuthLvl: 0,
	},


	/** ----------------------------------------------------------------------------
	 * Getters
	 */

	getters: {
		isAppConnected(state) {
			return state.connected;
		},

		getUserAccess(state) {
			return state.userAuthLvl;
		},
	},


	/** ----------------------------------------------------------------------------
	 * Mutations
	 */

	mutations: {
		appConnected(state, appInfo) {
			if (appInfo) {
				state.connected = true;
				state.userAuthLvl = appInfo['auth-lvl'];
			}
		},
	},


	/** ----------------------------------------------------------------------------
	 * Actions
	 */

	actions: {
	}
});