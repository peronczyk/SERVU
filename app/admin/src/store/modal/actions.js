export default {
	open({ state }, modalData) {
		state.isOpen  = true;
		state.content = modalData.content;
		state.props   = modalData.props;

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