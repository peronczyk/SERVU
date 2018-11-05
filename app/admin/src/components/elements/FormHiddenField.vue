<template>

	<input type="hidden" :value="value">

</template>


<script>

export default {
	props: [
		'value'
	],

	methods: {
		getValue() {
			return this.value;
		},

		validate() {
			return true;
		},

		reset() {},
	},
}

</script>
