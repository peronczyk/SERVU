<template>

	<nav class="c-Nav">
		<div class="c-Nav__top">
			<router-link to="/">
				<svg><use xlink:href="#logo-servant"></use></svg>
			</router-link>
		</div>

		<div class="c-Nav__links">
			<ul>
				<li v-for="route in $router.options.routes" :key="route.name" v-if="route.path != '/'">
					<router-link :to="route.path">
						<icon size="24" :glyph="route.icon" />
						{{ route.name }}
					</router-link>
				</li>
			</ul>
		</div>

		<div class="c-Nav__bottom">
			<a @click.prevent="logout()">Logout</a>
		</div>
	</nav>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

export default {
	methods: {
		...mapActions('user', [
			'logout'
		]),
	},
}

</script>



<style lang="scss">

@import '../assets/styles/_variables';

.c-Nav {
	display: flex;
	flex-direction: column;
	width: 100%;
	height: 100%;

	> * {
		width: 100%;
	}

	a {
		color: $color-text-lvl-3;

		.Icon {
			margin-right: 10px;
		}
	}

	&__top {
		display: flex;
		align-items: center;
		padding-left: $gutter;
		padding-right: $gutter;
		height: 14vh;
		min-height: 40px;

		a {
			display: inline-block;
			margin: auto;
			padding: 10px;

			&:hover {
				> svg {
					transform: scale(1.3) rotate(-8deg);
				}
			}

			&:active {
				> svg {
					transform: scale(1.1) rotate(-12deg);
				}
			}

			svg {
				width: 50px;
				height: 50px;
				transition: .4s;
				will-change: transform;
			}
		}
	}

	&__links {
		ul {
			list-style-type: none;
		}

		a {
			position: relative;
			display: flex;
			align-items: center;
			padding-left: $gutter;
			padding-right: $gutter;
			height: 8vh;
			font-size: 15px;

			&::after {
				content: '';
				position: absolute;
				top: 0;
				bottom: 0;
				right: 0;
				width: 2px;
				background-color: $color-links;
				opacity: 0;
				transform: scaleY(0);
				transition: .2s;
			}

			&:hover,
			&.router-link-exact-active {
				&::after {
					opacity: 1;
					transform: none;
				}
			}
		}
	}

	&__bottom {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-top: auto;
		height: 7vh;
		min-height: 40px;
		border-top: 1px solid $color-lines;

		a {
			display: inline-block;
			padding: 10px;
			font-size: 12px;
			font-weight: bold;
			text-transform: uppercase;
			transition: .2s;

			&:hover {
				color: $color-links-hover;
			}
		}
	}
}

</style>