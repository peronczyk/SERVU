<template>

	<div class="c-Sidebar">
		<the-nav v-if="isLoggedIn" />
		<login-info v-else />
	</div>

</template>


<script>

// Dependencies
import { mapGetters } from 'vuex';

// Components
import LoginInfo from './LoginInfo.vue';
import TheNav from './TheNav.vue';

export default {
	components: {
		LoginInfo, TheNav
	},

	computed: {
		...mapGetters('user', [
			'isLoggedIn'
		]),
	}
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
	background-color: $color-bg-lvl-3;
	transition: .4s;

	.is-UserLoggedIn & {
		width: 200px;
	}
}

</style>

