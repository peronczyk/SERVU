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

.c-Nav {
	$padding: 20px;

	display: flex;
	flex-direction: column;
	width: 100%;
	height: 100%;

	> * {
		width: 100%;
	}

	&__top {
		display: flex;
		align-items: center;
		padding-left: $padding;
		padding-right: $padding;
		height: 10vh;
		min-height: 40px;
	}

	&__links {
		a {
			display: flex;
			align-items: center;
			padding-left: $padding;
			padding-right: $padding;
			height: 5vh;
		}
	}

	&__bottom {
		margin-top: auto;
		height: 30px;
		text-align: center;
	}
}

</style>