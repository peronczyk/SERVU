<template>

	<div id="app" v-if="$store.getters.isAppConnected" :class="{'is-UserLoggedIn': $store.getters.getUserAccess > 0}">
		<the-sidebar />
		<the-main />
	</div>

</template>


<script>

import axios from 'axios';
import TheSidebar from './components/TheSidebar.vue';
import TheMain from './components/TheMain.vue';

export default {
	computed: {
	},

	created() {
		axios.get(window.appConfig.apiBaseUrl)
			.then(result => {
				this.$store.commit('appConnected', result.data['app-info']);
			})
			.catch(error => {
				console.error('Application could not connect to api');
				console.log(error);
			});
	},

	components: { TheSidebar, TheMain }
}

</script>


<style lang="scss">

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

html {
	height: 100%;
}

body {
	min-height: 100%;
	background-color: #f5f5f3;
}

#app {
	min-height: 100%;
}

a {
	cursor: pointer;
	color: blue;
}

</style>
