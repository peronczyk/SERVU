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

		<div class="c-Modal__bg" @click.prevent="closeModal"></div>
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
	background: none;
	overflow: auto;
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
		background-color: $color-bg-lvl-2;
		opacity: 0;
		transform: scale(.8);
		transition: .3s;
	}

	&__close {
		position: absolute;
		top: 8px;
		right: 8px;
		display: block;
		width: 40px;
		height: 40px;
		text-indent: -200px;
		overflow: hidden;
		transition: .2s;

		&:hover {
			background-color: $color-bg-lvl-3;
		}

		&::before,
		&::after {
			content: '';
			position: absolute;
			top: 20px;
			left: 11px;
			width: 20px;
			height: 1px;
			background-color: $color-links;
		}

		&::before {
			transform: rotate(45deg);
		}

		&::after {
			transform: rotate(-45deg);
		}
	}

	&__content {
		padding: $gutter #{$gutter * 1.5};
		overflow: hidden;
		text-align: left;
	}


	&__bg {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba($color-base-1, .8);
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
