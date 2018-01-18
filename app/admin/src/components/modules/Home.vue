<template>

	<div class="c-Home">
		<div class="c-Home__slogan">
			<h1>{{ siteName }}</h1>
			<h2>Administration panel</h2>
		</div>

		<ul class="c-Home__bottom">
			<li>
				App version:
				<strong>{{ $store.state.appVersion }}</strong>
			</li>

			<li>
				Provided by:
				<strong><a href="https://github.com/peronczyk/servant" target="_blank">Servant</a></strong>
			</li>
		</ul>
	</div>

</template>


<script>

export default {
	data() {
		return {
			siteName: window.appConfig.siteName,
		}
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-Home {
	position: relative;
	display: flex;
	align-items: center;

	&__slogan {
		h1 {
			margin: 0;
		}
	}

	&__bottom {
		list-style-type: none;
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		display: flex;
		align-items: center;
		padding-left: $gutter;
		padding-right: $gutter;
		height: 7vh;
		min-height: 40px;
		border-top: 1px solid $color-lines;

		li {
			color: $color-text-lvl-2;
			line-height: 1.4em;

			&:last-child {
				margin-left: auto;
				font-size: 12px;
			}

			strong {
				display: block;
				font-size: 1.1em;
				color: $color-text-lvl-1;
			}
		}
	}
}

</style>
