export default {
	bind(el, binding, vnode) {
		el.clickOutsideEvent = (event) => {
			// Check if clicked outside
			if (!(el === event.target || el.contains(event.target))) {
				// Call method provided in attribute value
				vnode.context[binding.expression](event);
			}
		};
		document.body.addEventListener('click', el.clickOutsideEvent)
	},

	unbind(el) {
		document.body.removeEventListener('click', el.clickOutsideEvent)
	},
};