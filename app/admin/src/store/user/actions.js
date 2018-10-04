import axios from 'axios';

export default {
	logout({ commit }) {
		commit('changeAccessLvl', 0);

		axios.get(window.appConfig.apiBaseUrl + 'users/logout')
			.then(result => {
				if (!result.data.status) {
					console.error('Logout failed');
				}
			});
	},
}