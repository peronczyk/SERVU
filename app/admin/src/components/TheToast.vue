<template>

	<dialog class="c-Toast" :class="{'is-Visible': isToastVisible}">
		<p v-html="toastContent" class="c-Toast__content"></p>

		<a @click.prevent="closeToast" class="c-Toast__close">
			<icon size="16" glyph="times"></icon>
		</a>
	</dialog>

</template>


<script>

export default {
	computed: {
		isToastVisible() {
			return this.$store.state.toast.isVisible;
		},

		toastContent() {
			return this.$store.state.toast.content;
		}
	},

	methods: {
		closeToast() {
			this.$store.commit('closeToast');
		}
	}
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-Toast {
	position: absolute;
	top: $gutter;
	left: auto; // Override browser defaults
	right: $gutter;
	visibility: hidden;
	display: flex;
	align-items: center;
	padding: #{$gutter * .5} 50px #{$gutter * .5} #{$gutter * .7};
	max-width: 400px;
	min-height: 60px;
	color: $color-white;
	background-color: $color-bg-lvl-4;
	opacity: 0;
	box-shadow: $shadow-lvl-3;
	transform: translateX(40px);
	transition: .4s;

	&.is-Visible {
		visibility: visible;
		opacity: 1;
		transform: none;
	}

	&__close {
		position: absolute;
		top: 16px;
		right: 10px;
		padding: 6px;
	}
}

</style>
