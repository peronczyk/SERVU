<template>

	<label
		:class="{
			'is-Dirty': isDirty,
			'is-Error': !isValid
		}"
		class="c-FormRich"
	>
		<div class="c-FormRich__label">
			<slot />
			<span class="u-Required" v-if="required"></span>
		</div>

		<div
			@focus="onFocus"
			@input="onChange"
			@blur="onBlur"
			class="c-FormRich__content"
			contenteditable="true"
		></div>
	</label>

</template>


<script>

const INITIAL_VALUE = '';

export default {
	props: {
		required: Boolean
	},

	data() {
		return {
			value: INITIAL_VALUE,
			isDirty: false,
			isValid: false,
		};
	},

	methods: {
		getValue() {
			return this.value;
		},

		validate() {
			return true;
		},

		reset() {
			this.value = INITIAL_VALUE;
		},

		onFocus() {
			console.log('Focus');
			this.isValid = true;
			this.isDirty = true;
		},

		onBlur() {
			console.log('Blur');
			this.value = event.target.innerText;
		},

		onChange(event) {
			console.log(event);
			this.value = event.target.innerText;
		},
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormRich {
	&__label {}

	&__content {
		min-height: 100px;
		padding: 20px;
		border: 1px solid $color-inputs-border;
		cursor: text;
		transition: .2s;

		&:focus {
			border-color: var(--color-brand);
		}
	}
}

</style>
