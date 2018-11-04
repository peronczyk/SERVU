<template>

	<ul class="c-Breadcrumbs">
		<li>Start</li>
		<li
			v-for="(chunk, index) in path"
			:key="(chunk.id) ? chunk.id : index"
			:title="(chunk.id) ? 'ID: ' + chunk.id : false"
		>
			<a v-if="clickAction" @click.prevent="clickAction(chunk.id)">{{ chunk.name }}</a>
			<span v-else>{{ chunk.name }}</span>
		</li>
	</ul>

</template>


<script>

export default {
	props: {
		path: Array,
		clickAction: Function,
	},
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-Breadcrumbs {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
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
