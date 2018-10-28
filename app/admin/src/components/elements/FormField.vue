<template>

	<label
		:class="{
			'is-Dirty': isDirty,
			'is-Error': !isValid
		}"
		class="c-FormField"
	>
		<div class="c-FormField__label u-FormFieldLabel">
			<slot />
			<span class="u-Required" v-if="required"></span>
		</div>

		<textarea
			v-if="type == 'textarea'"
			v-model="value"
			@focus="onFocus"
			@blur="onBlur"
			:name="name"
			:aria-invalid="!isValid"
		/>

		<input
			v-else-if="type == 'text'"
			v-model="value"
			@focus="onFocus"
			@blur="onBlur"
			:name="name"
			:aria-invalid="!isValid"
			type="text"
		>

		<input
			v-else-if="type == 'email'"
			v-model="value"
			@focus="onFocus"
			@blur="onBlur"
			:name="name"
			:aria-invalid="!isValid"
			type="email"
		>

		<input
			v-else-if="type == 'password'"
			v-model="value"
			@focus="onFocus"
			@blur="onBlur"
			:name="name"
			:aria-invalid="!isValid"
			type="password"
		>
	</label>

</template>


<script>

// Definitions
const INITIAL_VALUE = '';

export default {
	props: {
		type: {
			type: String,
			default: 'text',
		},

		// Required to get form autosuggestions work
		name: {
			type: String,
		},

		required: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			value: INITIAL_VALUE,
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
			this.value = INITIAL_VALUE;
			this.isDirty = false;
			this.isValid = true;
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
	margin-top: 14px;
	margin-bottom: 20px;
}

</style>
