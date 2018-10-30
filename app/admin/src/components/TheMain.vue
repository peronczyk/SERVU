<template>

	<div class="c-Main">

		<transition
			v-if="isLoggedIn"
			name="page"
			duration="2000"
		>
			<keep-alive>
				<router-view class="c-Main__view"></router-view>
			</keep-alive>
		</transition>

		<login-form v-else />
	</div>

</template>


<script>

// Components
import LoginForm from './LoginForm.vue';
import { mapGetters } from 'vuex';

export default {
	components: {
		LoginForm
	},

	computed: {
		...mapGetters('user', [
			'isLoggedIn',
		]),
	},
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-Main {
	position: relative;
	margin-left: 50%;
	height: 100%;
	transition: filter .3s;
	will-change: filter;

	.is-UserLoggedIn & {
		margin-left: var(--sidebar-size);
	}

	.is-ModalOpen & {
		filter: blur(4px);
	}

	&__view {
		padding: 0 var(--gutter-lg) 5vh var(--gutter-lg);
		height: 100%;
		will-change: transform, opacity;

		@include narrower-than(sm) {
			padding-top: var(--toolbar-size);
		}
	}
}

</style>
