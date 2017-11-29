<template>

	<div class="c-SideLeft">
		<login-info v-if="$store.getters.getUserAccess < 1" />
		<the-nav v-if="$store.getters.getUserAccess > 0" />
	</div>

</template>


<style lang="scss">

.c-SideLeft {
	position: fixed;
	display: flex;
	width: 50%;
	height: 100%;
	background-color: #fff;
	box-shadow: 0 0 100px rgba(0, 0, 0, .05);
	transition: .4s;

	.is-UserLoggedIn & {
		width: 20%;
		max-width: 250px;
	}
}

</style>


<script>

import LoginInfo from './LoginInfo.vue';
import TheNav from './TheNav.vue';

export default {
	components: { LoginInfo, TheNav }
}

</script>

