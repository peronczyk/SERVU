<template>

	<div class="c-SideRight">
		<login-form v-if="!$parent.isUserLoggedIn" />
		<transition>
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

.c-SideRight {

}

</style>
