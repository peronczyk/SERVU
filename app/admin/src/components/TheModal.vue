<template>

	<transition name="fade">
		<dialog
			v-if="isOpen"
			:aria-hidden="!isOpen"
			class="c-Modal"
			role="modal"
		>
			<div class="c-Modal__window" v-if="isOpen">
				<a class="c-Modal__close e-ToolBtn e-ToolBtn--close" @click.prevent="close"></a>

				<div class="c-Modal__content">
					<keep-alive>
						<component
							:is="getContent"
							v-bind="getProps"
						/>
					</keep-alive>
				</div>
			</div>

			<div class="c-Modal__bg" @click.prevent="close"></div>
		</dialog>
	</transition>

</template>


<script>

// Dependencies
import { mapGetters, mapActions } from 'vuex';

export default {
	computed: {
		...mapGetters('modal', [
			'isOpen',
			'getContent',
			'getProps',
		]),
	},

	methods: {
		...mapActions('modal', [
			'close',
		]),
	},
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.is-ModalOpen {
	overflow: hidden;
}

.c-Modal {
	display: block;
	position: fixed;
	top: 0;
	left: 0;
	z-index: +10;
	padding: var(--gutter);
	width: 100%;
	height: 100%;
	border: none;
	background: none;
	overflow: auto;
	text-align: center;

	&:before {
		content: '';
		display: inline-block;
		vertical-align: middle;
		width: 0;
		height: 100%;
		margin-left: -0.5em;
	}


	&__window {
		display: inline-block;
		vertical-align: middle;
		width: 100%;
		position: relative;
		z-index: +1;
		min-height: 40px;
		max-width: 1000px;
		border-top: 2px solid var(--color-brand);
		background-color: var(--color-bg-base);
		box-shadow: 0 20px 160px 0 rgba($color-base-lines, .1);
	}


	&__close {
		position: absolute;
		top: 10px;
		right: 10px;
	}


	&__content {
		min-height: 100px;
		padding: var(--gutter) var(--gutter-md);
		overflow: hidden;
		text-align: left;
	}


	&__bg {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba($color-base-lines, .05);
	}
}

</style>
