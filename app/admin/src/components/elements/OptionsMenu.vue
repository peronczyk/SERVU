<template>

	<div class="e-OptionsMenu" v-if="options.length">
		<a @click="toggleState" class="e-OptionsMenu__toggle">
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
import { mapGetters, mapMutations } from 'vuex';

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
		...mapMutations([
			'setOptionsMenuState',
		]),

		toggleState() {
			this.isOpen = !this.isOpen;
			this.setOptionsMenuState(this.isOpen);

			if (this.isOpen) {
				this.$eventBus.$emit('options-menu-open', this.menuId);
			}
		},

		close(id) {
			if (id !== this.menuId) {
				this.isOpen = false;
			}
		},

		runAction(action) {
			action();
			this.toggleState();
		},
	},

	created() {
		this.$eventBus.$on('options-menu-open', this.close);
	},

	beforeDestroy() {
		this.$eventBus.$off('options-menu-open', this.close);
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
		left: -6px;
		bottom: calc(100% + 10px);
		width: 14vw;
		min-width: 160px;
		max-width: 260px;
		padding: 6px 0 8px 0;
		list-style: none;
		line-height: 1.2em;
		text-align: left;
		background-color: $list-bg-color;
		box-shadow: 0 4px 40px rgba($color-black, .4);

		&::after {
			content: '';
			position: absolute;
			left: 10px;
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
				display: block;
				padding: 12px 20px;
			}
		}
	}
}

</style>
