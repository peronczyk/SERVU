<template>

	<div class="c-Home">
		<div class="c-Home__slogan">
			<p>Hello</p>
			<h1>{{ siteName }}</h1>
			<h2>Administration panel</h2>
		</div>

		<ul class="c-Home__bottom">
			<li>
				<small>App version:</small>
				<h4>{{ getAppVersion }}</h4>
			</li>

			<li>
				<small>PHP version:</small>
				<h4>{{ getPhpVersion }}</h4>
			</li>

			<li>
				<small>Provided by:</small>
				<h4><a href="https://github.com/peronczyk/servant" target="_blank">Servant</a></h4>
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

@import '../../assets/styles/definitions';

.c-Home {
	display: flex;
	align-items: center;
	height: 100vh;

	&__slogan {
		h1 {
			margin: 0;
		}

		// Large welcome header
		p {
			margin: 0 0 0 -10px;
			font-size: 160px;
			font-weight: bold;
			line-height: 1em;
			color: var(--color-bg-lighter);
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
		padding-left: var(--gutter);
		padding-right: var(--gutter);
		height: 7vh;
		min-height: 40px;
		border-top: 1px solid $color-lines;

		li {
			margin-right: var(--gutter);
			line-height: 1.4em;

			&:last-child {
				margin-left: auto;
				margin-right: 0;
			}

			h4 {
				margin: 0;
			}
		}
	}
}

</style>
