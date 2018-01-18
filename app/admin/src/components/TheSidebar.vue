<template>

	<div class="c-Sidebar">
		<login-info v-if="$store.getters.getUserAccess < 1" />
		<the-nav v-else />
	</div>

</template>


<script>

import LoginInfo from './LoginInfo.vue';
import TheNav from './TheNav.vue';

export default {
	components: { LoginInfo, TheNav }
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-Sidebar {
	position: fixed;
	z-index: +1;
	display: flex;
	width: 50%;
	height: 100%;
	background-color: $color-white;
	box-shadow: 0 0 100px rgba($color-black, .06);
	transition: .4s;

	.is-UserLoggedIn & {
		width: 200px;
	}
}

</style>

