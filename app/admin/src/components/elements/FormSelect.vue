<template>

	<select>
		<option v-for="(option, index) in options" :key="index" :value="option.id">{{ option.name }}</option>
	</select>

</template>


<script>

export default {
	props: {
		options: {
			type: Object,
			required: true,
		}
	},

	data() {
		return {
		}
	}
}

</script>
