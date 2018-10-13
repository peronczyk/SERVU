<template>

	<label
		class="c-FormSelect"
		:class="{
			'is-Dirty': isDirty,
			'is-Error': !isValid
		}"
	>
		<div class="c-FormSelect__label">
			<slot />
		</div>

		<select
			v-model="value"
			@focus="onFocus"
			@blur="onBlur"
			@change="onChange"
			:aria-invalid="!isValid"
		>
			<option
				v-for="(option, optionIndex) in options"
				:key="optionIndex"
				:value="option.value"
			>{{ option.name }}</option>
		</select>
	</label>

</template>


<script>

export default {
	props: {
		required: Boolean,

		options: {
			type: Array,
			required: true,
		},

		listener: {

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
			this.isValid = !(this.required && this.value.length < 1);
			return this.isValid;
		},

		reset() {
			this.value = '';
		},

		onFocus() {
			this.isValid = true;
		},

		onChange() {
			this.isDirty = true;

			if (this.listener) {
				this.listener(this.value);
			}
		},

		onBlur() {
			if (!this.value || this.value.length < 1) {
				this.isDirty = false;
			}
			else {
				this.validate();
			}
		}
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormSelect {
	position: relative;
	margin-bottom: 20px;
	padding-top: 14px;

	&__label {
		position: absolute;
		top: 20px;
		left: 0;
		z-index: -1;
		display: flex;
		align-items: center;
		height: var(--input-height);
		cursor: text;
		transition: .2s;

		.is-Dirty & {
			transform: translateY(calc(-.6 * var(--input-height)));
			font-size: .85em;
			color: $color-text-lvl-4;
			cursor: default;
		}
	}
}

</style>
