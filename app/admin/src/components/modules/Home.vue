<template>

	<div class="c-Home">
		<div class="c-Home__slogan">
			<p>Hello</p>
			<h1>{{ siteName }}</h1>
			<h2>Administration panel</h2>
		</div>

		<ul class="c-Home__bottom">
			<li>
				App version:
				<strong>{{ getAppVersion }}</strong>
			</li>

			<li>
				PHP version:
				<strong>{{ getPhpVersion }}</strong>
			</li>

			<li>
				Provided by:
				<strong><a href="https://github.com/peronczyk/servant" target="_blank">Servant</a></strong>
			</li>
		</ul>
	</div>

</template>


<script>

// Dependencies
import { mapGetters } from 'vuex';

export default {
	data() {
		return {
			siteName: window.appConfig.siteName,
		}
	},

	computed: {
		...mapGetters('base', [
			'getAppVersion',
			'getPhpVersion',
		]),
	},
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

		p {
			margin: 0 0 0 -10px;
			font-size: 160px;
			font-weight: bold;
			line-height: 1em;
			color: $color-bg-lvl-4;
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
			margin-right: $gutter;
			font-size: 13px;
			color: $color-text-lvl-3;
			line-height: 1.7em;

			&:last-child {
				margin-left: auto;
				margin-right: 0;

				strong {
					font-size: 1.1em;
				}
			}

			strong {
				display: block;
				font-size: 1.2em;
				letter-spacing: .05em;
				color: $color-text-lvl-1;
			}
		}
	}
}

</style>
