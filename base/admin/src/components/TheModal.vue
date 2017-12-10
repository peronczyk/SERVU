<template>

	<dialog class="c-Modal" :class="{'is-Open': isOpen}" role="modal" aria-hidden="true">
		<div class="c-Modal__window">
			<a class="c-Modal__close" @click.prevent="closeModal">close</a>
			<div class="c-Modal__content">
				<keep-alive>
					<component :is="content" />
				</keep-alive>
			</div>
		</div>
	</dialog>

</template>


<script>

export default {
	computed: {
		isOpen() {
			return this.$store.state.modal.isOpen;
		},

		content() {
			return this.$store.state.modal.content;
		},
	},

	methods: {
		openModal() {
			this.commit('openModal', "bla");
		},

		closeModal() {
			this.$store.commit('closeModal');
		},
	},
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-Modal {
	display: block;
	visibility: hidden;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 1000;
	padding: 40px;
	width: 100%;
	height: 100%;
	border: none;
	overflow: auto;
	background-color: rgba($color-dark, .8);
	text-align: center;
	opacity: 0;
	transition: .3s;

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
		max-width: 800px;
		background-color: $color-white;
		opacity: 0;
		transform: scale(.6);
		transition: .3s;
	}

	&__close {
		position: absolute;
		top: 0;
		right: 0;
	}

	&__content {
		padding: 30px;
		overflow: hidden;
		text-align: left;
	}

	&.is-Open {
		visibility: visible;
		opacity: 1;

		.c-Modal__window {
			opacity: 1;
			transform: scale(1);
		}

	}
}

</style>
