<template>

	<label
		:class="{
			'is-Dirty': isDirty,
			'is-Error': !isValid
		}"
		class="c-FormField"
	>
		<div class="c-FormField__label">
			<slot />
			<span class="u-Required" v-if="required"></span>
		</div>

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
		getValue() {
			return this.value;
		},

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

		reset() {
			this.value = '';
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

@import '../../assets/styles/definitions';

.c-FormField {
	position: relative;
	margin-bottom: 20px;
	padding-top: 14px;


	&__label {
		position: absolute;
		top: 14px;
		left: 0;
		display: flex;
		align-items: center;
		height: var(--input-height);
		cursor: text;
		transition: .2s;

		.is-Dirty & {
			transform: translateY(calc(-.6 * var(--input-height)));
			font-size: .85em;
			color: var(--color-text-dark);
			cursor: default;
		}
	}
}

</style>
