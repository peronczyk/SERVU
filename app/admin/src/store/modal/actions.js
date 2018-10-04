export default {
	open({ state }, content) {
		state.isOpen = true;
		state.content = content;
	},

	close({ state }) {
		state.isOpen = false;
		setTimeout(() => {
			state.content = null;
		}, 500);
	},
}