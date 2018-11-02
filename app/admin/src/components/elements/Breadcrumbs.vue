<template>

	<ul class="c-Breadcrumbs">
		<li>Start</li>
		<li v-for="(chunk, index) in path" :key="index" :title="'ID: ' + chunk.id">
			{{ chunk.name }}
		</li>
	</ul>

</template>


<script>

export default {
	props: {
		path: Array,
	},
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-Breadcrumbs {
	display: flex;
	list-style-type: none;
	margin-bottom: 10px;
	font-size: 16px;
	color: $color-text-lvl-2;

	li {
		position: relative;
		padding: 10px 30px 10px 0;

		&::before,
		&::after {
			content: '';
			position: absolute;
			right: 10px;
			width: 6px;
			height: 1px;
			background-color: $color-white;
		}

		&::before {
			top: calc(50% - 2px);
			transform: rotate(45deg);
		}

		&::after {
			top: calc(50% + 2px);
			transform: rotate(-45deg);
		}
	}
}

</style>
