export default {
	handleReceivedMeta({ state, commit }, meta) {
		state.connected = true;
		state.appVersion = meta['app-version'] || null;
		state.phpVersion = meta['php-version'] || null;

		if (meta['access-lvl']) {
			commit('user/changeAccessLvl', meta['access-lvl'], { root: true });
		}
	},
}