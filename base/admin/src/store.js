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
		}
	},


	/** ----------------------------------------------------------------------------
	 * Actions
	 */

	actions: {
	}
});