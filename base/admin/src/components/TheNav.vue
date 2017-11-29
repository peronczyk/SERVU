<template>

	<nav class="c-Nav">
		<div class="c-Nav__top"></div>

		<div class="c-Nav__links">
			<ul>
				<li v-for="route in $router.options.routes" :key="route.name">
					<router-link :to="route.path">
						{{route.name}}
					</router-link>
				</li>
			</ul>
		</div>

		<div class="c-Nav__bottom"></div>
	</nav>

</template>

<style lang="scss">

.c-Nav {
	display: flex;
	flex-direction: column;
	width: 100%;
	height: 100%;

	> * {
		width: 100%;
	}

	&__top {
		height: 10vh;
	}

	&__links {
		a {
			display: flex;
			align-items: center;
			padding-left: 20px;
			padding-right: 20px;
			height: 5vh;
		}
	}

	&__bottom {
		margin-top: auto;
		height: 30px;
	}
}

</style>
