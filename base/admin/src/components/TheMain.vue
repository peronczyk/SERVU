<template>

	<div class="c-Main">
		<login-form v-if="$store.getters.getUserAccess < 1" />
		<transition v-else>
			<router-view></router-view>
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

.c-Main {
	margin-left: 50%;

	.is-UserLoggedIn & {
		margin-left: 250px;
	}
}

</style>
