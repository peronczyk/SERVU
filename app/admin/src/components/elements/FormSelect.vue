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

		<a
			@click.prevent="toggleOpen"
			:name="name"
			class="c-FormSelect__toggle"
		>
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
						@keydown.space.prevent="selectOption(option, index)"
						@keydown.enter.prevent="selectOption(option, index)"
						:class="{'is-Selected': isSelected(option.value)}"
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

// Definitions
const INITIAL_VALUE = '';

export default {
	props: {
		required: Boolean,

		options: {
			type: Array,
			required: true,
		},

		name: {
			type: String,
		},

		changeCallback: {
			type: Function,
		},
	},

	data() {
		return {
			value               : INITIAL_VALUE,
			isOpen              : false,
			isDirty             : false,
			isValid             : true,
			focusedOptionNumber : -1,
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

		setValue(value) {
			this.value = value;
			this.isDirty = (value);
		},

		validate() {
			this.isValid = !(this.required && this.value.length < 1);
			return this.isValid;
		},

		reset() {
			this.value = INITIAL_VALUE;
			this.isDirty = false;
			this.isValid = true;

			if (this.changeCallback) {
				this.changeCallback(null);
			}
		},

		open() {
			this.isOpen = true;
		},

		close() {
			this.isOpen = false;
			this.focusedOptionNumber = -1;
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

			this.focusedOptionNumber = optionIndex;
		},

		isSelected(optionValue) {
			return optionValue === this.value;
		},

		handleKeypress(event) {
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
			// Choose index of option to set focus
			if (this.focusedOptionNumber < 1 && dir < 0) {
				this.focusedOptionNumber = this.options.length - 1;
			}
			else if (this.focusedOptionNumber == this.options.length - 1 && dir > 0) {
				this.focusedOptionNumber = 0;
			}
			else {
				this.focusedOptionNumber += dir;
			}

			// Set focus to option
			this.$refs.option[this.focusedOptionNumber].focus();
		},
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormSelect {
	position: relative;
	min-width: 80px;
	margin-top: 14px;
	margin-bottom: 20px;

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

		&::after {
			content: '';
			position: absolute;
			top: calc(50% - 5px);
			right: 16px;
			width: 6px;
			height: 6px;
			border-style: solid;
			border-color: var(--color-link);
			border-width: 0 1px 1px 0;
			transform: rotate(45deg);
			transition: .2s;
		}

		&,
		&:hover {
			color: var(--color-text-base);
		}

		:focus &,
		.is-Open & {
			border-color: var(--color-brand);
		}

		.is-Open & {
			&::after {
				transform: rotate(-135deg);
			}
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

			&.is-Selected {
				background-color: rgba($color-white, .03);
			}

			&:hover,
			&:focus {
				color: var(--color-text-base);
				background-color: rgba($color-white, .05);
			}
		}
	}
}

</style>
