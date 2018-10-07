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
		getValue() {
			return this.value;
		},

		validate() {
			return true;
		}
	},
}

</script>
