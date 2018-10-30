export default {
	open({ state }, content) {
		state.isOpen = true;
		state.content = content;
		document.documentElement.classList.add('is-ModalOpen');
	},

	close({ state }) {
		state.isOpen = false;
		document.documentElement.classList.remove('is-ModalOpen');
		setTimeout(() => {
			state.content = null;
		}, 500);
	},
}