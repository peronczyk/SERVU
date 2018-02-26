<template>

	<input type="hidden" v-model="value">

</template>


<script>

export default {
	props: {
		value: {
			type: String,
		}
	},

	data() {
		return {
		}
	},

	methods: {
		validate() {
			console.log(this.value);
			return true;
		}
	},
}

</script>
