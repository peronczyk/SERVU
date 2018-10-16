export default {
	open({ state }, { message, callback }) {
		state.content = message;
		state.isOpen = true;
		state.callback = callback;
	},

	confirm({ state, dispatch }) {
		(state.callback)
			? state.callback()
			: console.warn('[Dialog] Callback function is missing.');

		dispatch('close');
	},

	close({ state }) {
		state.content = '';
		state.isOpen = false;
		state.callback = null;
	},
}