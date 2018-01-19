<template>

	<label class="c-FormCheckbox" :class="{'is-Checked': fieldValue, 'is-Error': !isValid}">
		<div class="c-FormCheckbox__input">
			<input type="checkbox" v-model="fieldValue" @change="onChange">
		</div>
		<div class="c-FormCheckbox__desc">
			<slot />
			<span class="u-Required" title="This option is required" v-if="required"></span>
		</div>
	</label>

</template>


<script>

export default {
	data() {
		return {
			fieldValue: false,
			isValid: true,
		}
	},

	props: {
		required: {
			type: Boolean,
			default: false,
		},
	},

	methods: {
		validate() {
			this.isValid = true;

			if (this.required && !this.fieldValue) {
				this.isValid = false;
			}

			return this.isValid;
		},

		onChange(event) {
			if (this.required && this.fieldValue) {
				this.isValid = true;
			}
		}
	},

	mounted() {
		if (this.$el.attributes.getNamedItem('checked')) {
			this.fieldValue = true;
		}
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-FormCheckbox {
	display: flex;
	margin-bottom: $inputs-height / 2;

	&__input {
		position: relative;
		flex-shrink: 0;
		width: 26px;
		height: 26px;
		border: 1px solid $color-inputs-border;
		overflow: hidden;
		cursor: pointer;
		transition: .3s;

		&::before,
		&::after {
			content: '';
			position: absolute;
			height: 2px;
			background-color: $color-base-1;
			transition: .1s;
			transform-origin: left;
		}

		&::before {
			top: 10px;
			left: 6px;
			width: 7px;
			transform: rotate(45deg) scaleX(0);
			transition-delay: .1s;
		}

		&::after {
			top: 14px;
			left: 11px;
			width: 11px;
			transform: rotate(-45deg) scaleX(0);
			transition-delay: 0s;
		}

		input {
			position: absolute;
			left: -30px;
			height: 1px;
			width: 1px;
		}

		.is-Checked & {
			&::before {
				transform: rotate(45deg) scaleX(1);
				transition-delay: 0s;
			}

			&::after {
				transform: rotate(-45deg) scaleX(1);
				transition-delay: .1s;
			}
		}

		.is-Error & {
			transition: .2s;
			border-color: $color-errors;
		}

		label:active & {
			transform: scale(.9);
		}
	}


	&__desc {
		padding-top: 3px;
		padding-left: 16px;
	}
}

</style>
