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

	.is-UserLoggedIn & {
		margin-left: 200px;

		@include narrower-than(lg) {
			margin-left: 170px;
		}

		@include narrower-than(md) {
			margin-left: 140px;
		}

		@include narrower-than(sm) {
			margin-left: 90px;
		}
	}

	&__view {
		padding: 0 var(--gutter-lg) 5vh var(--gutter-lg);
		height: 100%;
		will-change: transform, opacity;
	}
}

</style>
