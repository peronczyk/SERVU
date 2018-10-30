<template>

	<transition name="fade">
		<dialog
			v-if="isOpen"
			v-click-outside="close"
			:aria-hidden="!isOpen"
			class="c-Dialog"
			role="alertdialog"
		>
			<div class="c-Dialog__content">
				<p v-html="getContent"></p>
			</div>

			<div class="c-Dialog__buttons">
				<button class="Btn" @click="confirm" ref="confirmButton">Yes</button>
				<button class="Btn Btn--hollow" @click="close">No</button>
			</div>
		</dialog>
	</transition>

</template>


<script>

// Dependencies
import { mapGetters, mapActions } from 'vuex';

export default {
	props: {

	},

	computed: {
		...mapGetters('dialog', [
			'isOpen',
			'getContent',
		]),
	},

	methods: {
		...mapActions('dialog', [
			'close',
			'confirm',
		]),
	},
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-Dialog {
	position: fixed;
	z-index: +2;
	top: 40%;
	left: 50%;
	display: block;
	width: 400px;
	max-width: 95%;
	min-height: 100px;
	background-color: var(--color-bg-lighter);
	box-shadow: $shadow-lvl-3;
	transform: translate(-50%, -40%);


	&__buttons,
	&__content {
		padding: 20px 30px;

		@include narrower-than(md) {
			padding: 14px 18px;
		}
	}


	&__buttons {
		display: flex;
		border-top: 1px solid $color-lines;

		.Btn {
			margin-right: 10px;
			min-width: 80px;
		}
	}
}

</style>
