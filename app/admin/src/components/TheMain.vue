<template>

	<div class="c-Main">
		<login-form v-if="$store.getters.getUserAccess < 1" />

		<transition
			v-else
			name="page"
			duration="2000"
		>
			<keep-alive>
				<router-view class="c-Main__view"></router-view>
			</keep-alive>
		</transition>
	</div>

</template>


<script>

// Components
import LoginForm from './LoginForm.vue';

export default {
	components: { LoginForm }
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-Main {
	position: relative;
	margin-left: 50%;
	height: 100%;

	.is-UserLoggedIn & {
		margin-left: 200px;
	}

	&__view {
		padding: 0 $gutter * 2;
		height: 100%;
	}
}

</style>
