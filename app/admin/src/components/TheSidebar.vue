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

@import '../assets/styles/definitions';

.c-Sidebar {
	position: fixed;
	z-index: +1;
	display: flex;
	width: 50%;
	height: 100%;
	background-color: var(--color-bg-light);
	transition: width .8s, filter .3s;
	will-change: width, filter;

	.is-UserLoggedIn & {
		width: var(--sidebar-size);

		@include narrower-than(sm) {
			width: 100%;
			height: var(--toolbar-size);
		}
	}

	.is-ModalOpen & {
		filter: blur(4px);
	}
}

</style>

