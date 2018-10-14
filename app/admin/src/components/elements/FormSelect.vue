<template>

	<label
		@keydown="handleKeypress"
		v-click-outside="close"
		:class="{
			'is-Open' : isOpen,
			'is-Dirty': isDirty,
			'is-Error': !isValid
		}"
		class="c-FormSelect"
		tabindex="0"
	>
		<div class="c-FormSelect__label u-FormFieldLabel">
			<slot />
		</div>

		<a @click.prevent="toggleOpen" class="c-FormSelect__toggle">
			<span v-html="selectedValueLabel"></span>
		</a>

		<div class="c-FormSelect__options">
			<transition name="scale-y">
				<ul
					v-show="isOpen"
					:aria-invalid="!isValid"
					role="listbox"
				>
					<li
						v-for="(option, index) in options"
						@click.prevent="selectOption(option, index)"
						:class="{'is-Checked': isChecked(option.value)}"
						:key="index"
						tabindex="0"
						role="option"
						ref="option"
					>
						{{ option.name }}
					</li>
				</ul>
			</transition>
		</div>
	</label>

</template>


<script>

const INITIAL_VALUE = '';

export default {
	props: {
		required: Boolean,

		options: {
			type: Array,
			required: true,
		},

		changeCallback: {
			type: Function,
		},
	},

	data() {
		return {
			value: INITIAL_VALUE,
			isOpen: false,
			isDirty: false,
			isValid: true,
		}
	},

	computed: {
		selectedValueLabel() {
			let valueFound = this.options.filter(option => option.value === this.value);
			return (valueFound.length)
				? valueFound[0].name
				: INITIAL_VALUE;
		},
	},

	methods: {
		getValue() {
			return this.value;
		},

		validate() {
			this.isValid = !(this.required && this.value.length < 1);
			return this.isValid;
		},

		reset() {
			this.value = INITIAL_VALUE;
		},

		open() {
			this.isOpen = true;
		},

		close() {
			this.isOpen = false;
		},

		toggleOpen() {
			(this.isOpen) ? this.close() : this.open();
		},

		selectOption(optionData, optionIndex) {
			this.value = optionData.value;
			this.isDirty = true;
			this.toggleOpen();

			if (this.changeCallback) {
				this.changeCallback(this.value);
			}
		},

		isChecked(optionValue) {
			return optionValue === this.value;
		},

		handleKeypress(event) {
			console.log(event);
			switch(event.code) {
				case 'Space':
					event.preventDefault();
					this.toggleOpen();
					break;

				case 'Enter':
					this.open();
					break;

				case 'Escape':
					this.close();
					break;

				case 'Tab':
					this.close();
					break;

				case 'ArrowDown':
					event.preventDefault();
					(this.isOpen)
						? this.handleArrowKey(1)
						: this.open();
					break;

				case 'ArrowUp':
					if (this.isOpen) {
						event.preventDefault();
						this.handleArrowKey(-1);
					}
					break;
			}
		},

		handleArrowKey(dir) {

		},
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormSelect {
	position: relative;
	min-width: 80px;
	margin-bottom: 20px;
	padding-top: 14px;

	&__label {
		z-index: -1; // Hide under the __toggle element
	}


	&__toggle {
		display: flex;
		align-items: center;
		height: var(--input-height);
		border-bottom: 1px solid $color-inputs-border;
		color: var(--color-text-base);
		transition: .2s;

		&,
		&:hover {
			color: var(--color-text-base);
		}

		:focus &,
		.is-Open & {
			border-color: var(--color-brand);
		}
	}


	&__options {
		position: relative;
		height: 0;

		ul {
			position: absolute;
			z-index: +2;
			top: 0;
			left: 0;
			width: 100%;
			min-width: 140px;
			list-style-type: none;
			background-color: var(--color-bg-light);
			box-shadow: $shadow-lvl-1;
			transform-origin: top;
		}

		li {
			padding: 12px 16px;
			cursor: pointer;

			&:hover {
				background-color: rgba($color-white, .05);
			}
		}
	}
}

</style>
