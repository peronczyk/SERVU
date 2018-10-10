import axios from 'axios';

export default {
	fetchList({ commit }) {
		commit('setIsFetched', false);

		axios.get(window.appConfig.apiBaseUrl + 'collections/list/')
			.then(result => {
				commit('setIsFetched', true);
				commit('setList', result.data.data);
			});
	},
}