<template>

	<svg class="Icon" v-bind="{'class': 'Icon--' + size}">
		<use v-bind="{'xlink:href': '#icon-' + size + '_' + glyph}"></use>
	</svg>

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

.Icon {
	display: inline-block;
	vertical-align: middle;
	color: inherit;

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

.filled {
	fill: currentColor;
}

.stroked {
	stroke: currentColor;
	fill: none;
}

</style>

