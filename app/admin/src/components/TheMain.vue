<template>

	<div class="c-Main">

		<transition
			v-if="isUserLoggedIn"
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
		...mapGetters({
			userAccess: 'getUserAccess',
		}),

		isUserLoggedIn() {
			return (this.userAccess > 0);
		}
	},
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
