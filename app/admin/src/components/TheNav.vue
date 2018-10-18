<template>

	<nav
		v-click-outside="closeMenu"
		:class="{'is-Open': isMenuOpen}"
		class="c-Nav"
	>
		<div class="c-Nav__top">
			<router-link to="/">
				<svg><use xlink:href="#logo-servant"></use></svg>
			</router-link>
		</div>

		<div class="c-Nav__links">
			<ul>
				<li
					v-for="route in $router.options.routes"
					v-if="route.path != '/'"
					@click="closeMenu"
					:key="route.name"
				>
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

		<a
			@click.prevent="toggleMenuVisibility"
			class="c-Nav__toggle"
		></a>
	</nav>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

export default {
	data() {
		return {
			isMenuOpen: false,
		}
	},

	methods: {
		...mapActions('user', [
			'logout'
		]),

		closeMenu() {
			this.isMenuOpen = false;
		},

		toggleMenuVisibility() {
			this.isMenuOpen = !this.isMenuOpen;
		},
	},
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-Nav {
	position: relative;
	display: flex;
	flex-direction: column;
	width: 100%;
	height: 100%;


	a {
		color: $color-text-lvl-3;
	}


	&__top {
		display: flex;
		align-items: center;

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

		// Desktop only
		@include wider-than(sm) {
			height: 14vh;
			min-height: 80px;
			padding-left: var(--gutter);
			padding-right: var(--gutter);
		}

		// Mobile only
		@include narrower-than(sm) {
			width: var(--toolbar-size);
			height: 100%;

			a {
				display: flex;
				align-items: center;
				justify-content: center;
				height: 100%;
				padding: 0;

				svg {
					width: 60%;
					height: 60%;
				}
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
			padding: 0 30px;
			height: 8vh;
			min-height: 40px;

			&::after {
				content: '';
				position: absolute;
				top: 0;
				bottom: 0;
				right: 0;
				width: 2px;
				background-color: var(--color-link);
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

			.Icon {
				flex-shrink: 0;
				margin-right: 12px;
				color: var(--color-text-base);
			}

			@include narrower-than(lg) {
				padding: 0 20px;
			}

			@include narrower-than(md) {
				padding: 0 14px;
				font-size: 14px;
			}

			@include narrower-than(sm) {
				height: auto;
				padding: 20px;
			}
		}

		@include narrower-than(sm) {
			position: absolute;
			top: 100%;
			left: 0;
			right: 0;
			height: 0;

			ul {
				visibility: hidden;
				opacity: 0;
				background-color: var(--color-bg-light);
				transform: scaleY(0);
				transform-origin: top;
				transition: .3s;
				will-change: visibility, opacity, transform;

				.is-Open & {
					visibility: visible;
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

		@include narrower-than(sm) {
			display: none;
		}
	}


	&__toggle {
		display: none;

		@include narrower-than(sm) {
			display: flex;
			align-items: center;
			justify-content: center;
			width: var(--toolbar-size);
			height: 100%;
			margin-left: auto;

			&::before {
				content: '';
				display: block;
				height: 1px;
				width: 40%;
				background-color: var(--color-link);
				box-shadow:
					0  7px 0 0 var(--color-link),
					0 -7px 0 0 var(--color-link);
				transition: .2s;
			}

			.is-Open & {
				&::before {
					box-shadow:
						0  5px 0 0 var(--color-link),
						0 -5px 0 0 var(--color-link);
				}
			}
		}
	}


	@include narrower-than(sm) {
		flex-direction: row;
		height: var(--toolbar-size);
	}
}

</style>