<template>

	<div
		v-if="options.length"
		v-click-outside="close"
		class="e-OptionsMenu"
	>
		<a @click="toggle" class="e-OptionsMenu__toggle">
			<span></span>
			<span></span>
			<span></span>
		</a>

		<transition name="slide-bottom">
			<ul class="e-OptionsMenu__list" v-if="isOpen">
				<li v-for="(option, index) in options" :key="index">
					<a
						@click.prevent="runAction(option.action)"
						v-html="option.name"
					></a>
				</li>
			</ul>
		</transition>
	</div>

</template>


<script>

// Dependencies
import { mapMutations } from 'vuex';

export default {
	props: {
		options: {
			type: Array,
		},
	},

	data() {
		return {
			isOpen: false,

			// Generate random ID string to allow to distinguish component instances
			menuId: Math.random().toString(36).substring(2, 15),
		}
	},

	methods: {
		...mapMutations('optionsmenu', [
			'setState',
		]),

		toggle() {
			(this.isOpen)
				? this.close()
				: this.open();
		},

		open() {
			this.isOpen = true;
			this.setState(true);
			this.$root.$emit('OPTIONS_MENU_OPEN', this.menuId);
		},

		close() {
			this.isOpen = false;
			this.setState(false);
		},

		externalClose(id) {
			if (id !== this.menuId) {
				this.isOpen = false;
			}
		},

		runAction(action) {
			action();
			this.toggle();
		},
	},
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.e-OptionsMenu {
	$toggle-size: 26px;
	$dot-size: 4px;
	$list-bg-color: $color-bg-lvl-4;

	position: relative;
	display: inline-block;

	&__toggle {
		position: relative;
		display: block;
		width: $toggle-size;
		height: $toggle-size;
		transition: .2s;

		span {
			position: absolute;
			top: calc(50% - #{$dot-size / 2});
			width: $dot-size;
			height: $dot-size;
			border-radius: 100%;
			background-color: $color-base-1;

			&:nth-child(1) {
				left: 4px;
			}

			&:nth-child(2) {
				left: calc(50% - #{$dot-size / 2});
			}

			&:nth-child(3) {
				right: 4px;
			}
		}

		&:hover {
			background-color: $color-bg-lvl-4;
		}
	}

	&__list {
		position: absolute;
		z-index: +1;
		right: -28px;
		bottom: calc(100% + 10px);
		width: 14vw;
		min-width: 160px;
		max-width: 260px;
		list-style: none;
		line-height: 1.2em;
		text-align: left;
		background-color: $list-bg-color;
		box-shadow: $shadow-lvl-2;

		// Pointing down triangle
		&::after {
			content: '';
			position: absolute;
			right: 33px;
			bottom: -8px;
			width: 16px;
			height: 16px;
			transform: rotate(45deg);
			background-color: $list-bg-color;
		}

		li {
			border-bottom: 1px solid $color-lines;

			&:last-child {
				border: none;
			}

			a {
				position: relative;
				z-index: +1;
				display: block;
				padding: 16px 20px;
				user-select: none;

				&:hover {
					background-color: rgba($color-white, .03);
				}
			}
		}
	}
}

</style>
