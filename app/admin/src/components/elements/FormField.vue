<template>

	<label class="c-FormField" :class="{'is-Dirty': isDirty, 'is-Error': !isValid}">
		<div class="c-FormField__label">
			<slot />
			<span class="u-Required" v-if="required"></span>
		</div>

		<span class="c-FormField__error" v-if="!isValid" title="This field is required - please fill it">
			<icon size="16" glyph="error" />
		</span>

		<textarea
			v-if="type == 'textarea'"
			v-model="value"
			:aria-invalid="!isValid"
			@focus="onFocus"
			@blur="onBlur"
		/>

		<input
			v-else-if="type == 'text'"
			v-model="value"
			:aria-invalid="!isValid"
			@focus="onFocus"
			@blur="onBlur"
			type="text"
		>

		<input
			v-else-if="type == 'email'"
			v-model="value"
			:aria-invalid="!isValid"
			@focus="onFocus"
			@blur="onBlur"
			type="email"
		>

		<input
			v-else-if="type == 'password'"
			v-model="value"
			:aria-invalid="!isValid"
			@focus="onFocus"
			@blur="onBlur"
			type="password"
		>
	</label>

</template>


<script>

export default {
	props: {
		type: {
			type: String,
			default: 'text',
		},

		required: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			value: '',
			isDirty: false,
			isValid: true,
		}
	},

	methods: {
		validate() {
			this.isValid = true;

			if (this.required && this.value.length < 1) {
				this.isValid = false;
			}
			else if (this.type == 'email' && !/\S+@\S+/.test(this.value)) {
				this.isValid = false;
			}

			return this.isValid;
		},

		onFocus() {
			this.isValid = true;
			this.isDirty = true;
		},

		onBlur() {
			if (this.value.length < 1) {
				this.isDirty = false;
			}
			else {
				this.validate();
			}
		},
	},
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-FormField {
	position: relative;
	margin-bottom: 20px;
	padding-top: 20px;


	&__label {
		position: absolute;
		top: 20px;
		left: 0;
		display: flex;
		align-items: center;
		height: $inputs-height;
		cursor: text;
		transition: .2s;

		.is-Dirty & {
			transform: translateY(-.6 * $inputs-height);
			font-size: .85em;
			color: $color-text-lvl-4;
			cursor: default;
		}
	}


	&__error {
		position: absolute;
		top: $inputs-height / 2 - 10px;
		right: 10px;
		cursor: help;

		.Icon {
			color: $color-errors;
		}
	}
}

</style>
