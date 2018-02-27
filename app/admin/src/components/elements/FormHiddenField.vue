<template>

	<input type="hidden" :value="value">

</template>


<script>

export default {
	props: {
		value: {
			type: String,
		}
	},

	methods: {
		validate() {
			return true;
		}
	},
}

</script>
