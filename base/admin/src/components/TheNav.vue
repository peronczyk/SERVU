<template>

	<nav class="c-Nav">
		<div class="c-Nav__top">
			<h3>Admin</h3>
		</div>

		<div class="c-Nav__links">
			<ul>
				<li v-for="route in $router.options.routes" :key="route.name">
					<router-link :to="route.path">
						{{route.name}}
					</router-link>
				</li>
			</ul>
		</div>

		<div class="c-Nav__bottom">
			<a @click.prevent="logout()">logout</a>
		</div>
	</nav>

</template>


<script>

import axios from 'axios';

export default {
	methods: {
		logout() {
			axios.get(window.appConfig.apiBaseUrl + 'users/logout')
				.then(receivedData => {
					if (receivedData.data.status) {
						this.$store.commit('changeUserAccessLvl', receivedData.data.meta['access-lvl']);
					}
					else {
						console.error('Logout failed');
					}
				});
		}
	}
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
		color: $color-text;
	}

	&__top {
		display: flex;
		align-items: center;
		padding-left: $gutter;
		padding-right: $gutter;
		height: 10vh;
		min-height: 40px;

		h3 {
			margin: 0;
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
		margin-top: auto;
		height: 30px;
		text-align: center;
	}
}

</style>