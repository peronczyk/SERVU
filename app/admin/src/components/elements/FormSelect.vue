<template>

	<label class="c-FormSelect" :class="{'is-Dirty': isDirty, 'is-Error': !isValid}">
		<div class="c-FormSelect__label">
			{{ label }}
		</div>

		<select
		 v-model="fieldValue"
		 :aria-invalid="!isValid"
		 @focus="onFocus"
		 @blur="onBlur"
		 @change="onChange"
		>
			<slot />
		</select>
	</label>

</template>


<script>

export default {
	props: {
		label: {
			type: String,
			required: true,
		}
	},

	data() {
		return {
			fieldValue: '',
			isDirty: false,
			isValid: true,
		}
	},

	methods: {
		validate() {
			console.log('Validate');
		},

		onFocus() {
			this.isValid = true;
		},

		onChange() {
			this.isDirty = true;
		},

		onBlur() {
			if (this.fieldValue.length < 1) {
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

@import '../../assets/styles/_variables';

.c-FormSelect {
	position: relative;
	margin-bottom: 20px;
	padding-top: 20px;

	&__label {
		position: absolute;
		top: 20px;
		left: 0;
		z-index: -1;
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
}

</style>
