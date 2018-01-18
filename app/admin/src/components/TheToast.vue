<template>

	<dialog class="c-Toast" :class="{'is-Visible': isToastVisible}">
		<div class="c-Toast__content" v-html="toastContent"></div>
		<a class="c-Toast__close" @click.prevent="closeToast">x</a>
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
	padding-right: 20px;
	max-width: 300px;
	min-height: 60px;
	color: $color-white;
	background-color: $color-dark;
	opacity: 0;
	transform: translateX(40px);
	transition: .4s;

	&.is-Visible {
		visibility: visible;
		opacity: 1;
		transform: none;
	}

	&__content {
		padding: #{$gutter * .5} #{$gutter * .7};
		line-height: 1.2em;
	}

	&__close {
		position: absolute;
		top: 10px;
		right: 10px;
	}
}

</style>
