<template>

	<div
		v-bind="{'class': 'e-Icon--' + size}"
		:title="glyph"
		class="e-Icon"
	></div>

</template>


<script>

export default {
	props: {
		size: {
			type: String,
			default: '24',
		},

		glyph: {
			type: String,
			required: true,
		}
	}
}

</script>



<style lang="scss">

@import '../../assets/styles/_variables';

.e-Icon {
	display: inline-block;
	vertical-align: middle;
	background-color: rgba($color-white, .1);

	&--16 {
		width: 16px;
		height: 16px;
	}

	&--24 {
		width: 24px;
		height: 24px;
	}

	&--48 {
		width: 48px;
		height: 48px;
	}
}

</style>

