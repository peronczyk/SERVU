<template>

	<transition name="slide-right">
		<dialog
			v-if="isVisible"
			:aria-hidden="!isVisible"
			class="c-Toast"
		>
			<p v-html="getContent" class="c-Toast__content"></p>

			<a @click.prevent="close" class="c-Toast__close e-ToolBtn e-ToolBtn--close"></a>
		</dialog>
	</transition>

</template>


<script>

// Dependencies
import { mapGetters, mapActions } from 'vuex';

export default {
	computed: {
		...mapGetters('toast', [
			'isVisible',
			'getContent',
		]),
	},

	methods: {
		...mapActions('toast', [
			'close',
		]),
	}
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-Toast {
	position: fixed;
	z-index: +20; // Twice as modal
	bottom: var(--gutter);
	left: auto; // Override browser defaults
	right: var(--gutter);
	display: flex;
	align-items: center;
	padding: 14px calc(var(--tool-btn-size) + 30px) 14px 26px;
	max-width: 400px;
	min-height: 60px;
	color: $color-white;
	background-color: var(--color-bg-lighter);
	box-shadow: $shadow-lvl-3;
	transition: .4s;

	&__content {
		width: 100%;
		overflow-wrap: break-word;
		word-wrap: break-word;
	}

	&__close {
		position: absolute;
		top: 10px;
		right: 10px;
	}
}

</style>
