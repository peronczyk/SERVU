export default {
	open({ state }, content) {
		state.isVisible = !state.isVisible;
		state.content = content;
	},

	close({ state }) {
		state.isVisible = false;
		setTimeout(() => {
			state.content = null;
		}, 500);
	},
}