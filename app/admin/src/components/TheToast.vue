<template>

	<transition name="slide-right">
		<dialog
			v-if="isVisible"
			:aria-hidden="!isVisible"
			class="c-Toast"
		>
			<p v-html="getContent" class="c-Toast__content"></p>

			<a @click.prevent="close" class="c-Toast__close">
				<icon size="16" glyph="times"></icon>
			</a>
		</dialog>
	</transition>

</template>


<script>

// Dependencies
import { mapGetters, mapMutations } from 'vuex';

export default {
	computed: {
		...mapGetters('toast', [
			'isVisible',
			'getContent',
		]),
	},

	methods: {
		...mapMutations('toast', [
			'close',
		]),
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
	display: flex;
	align-items: center;
	padding: #{$gutter * .5} 50px #{$gutter * .5} #{$gutter * .7};
	max-width: 400px;
	min-height: 60px;
	color: $color-white;
	background-color: $color-bg-lvl-4;
	box-shadow: $shadow-lvl-3;
	transition: .4s;

	&__close {
		position: absolute;
		top: 16px;
		right: 10px;
		padding: 6px;
	}
}

</style>
