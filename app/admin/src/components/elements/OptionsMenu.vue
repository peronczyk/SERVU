<template>

	<div
		v-if="options.length"
		v-click-outside="close"
		:class="{'is-Open': isOpen}"
		class="e-OptionsMenu"
	>
		<a @click="toggle" class="e-ToolBtn e-ToolBtn--options"></a>

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
	$list-bg-color: $color-bg-lvl-4;

	position: relative;
	display: inline-block;


	&__list {
		position: absolute;
		z-index: +1;
		right: 0;
		bottom: 100%;
		width: 14vw;
		min-width: 160px;
		max-width: 260px;
		list-style: none;
		line-height: 1.2em;
		text-align: left;
		background-color: $list-bg-color;
		box-shadow: $shadow-lvl-2;

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
