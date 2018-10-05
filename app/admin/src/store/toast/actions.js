export default {
	open({ state, dispatch }, content) {
		state.isVisible = true;
		state.content = content;

		setTimeout(() => {
			dispatch('close');
		}, 12000);
	},

	close({ state }) {
		state.isVisible = false;

		setTimeout(() => {
			state.content = null;
		}, 500);
	},
}