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
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-FormSelect {

}

</style>
