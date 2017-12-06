<template>

	<div class="c-Main">
		<login-form v-if="$store.getters.getUserAccess < 1" />
		<transition v-else duration="5000">
			<router-view class="c-Main__view"></router-view>
		</transition>
	</div>

</template>


<script>

import LoginForm from './LoginForm.vue';

export default {
	components: { LoginForm }
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-Main {
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
