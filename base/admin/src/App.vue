<template>

	<div id="app" :class="{'is-AppConnected': $store.getters.isAppConnected, 'is-UserLoggedIn': $store.getters.getUserAccess > 0}">
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
			.then(receivedData => {
				if (receivedData.data['meta']) {
					this.$store.commit('appConnected', receivedData.data['meta']);
				}
				else {
					console.error('No meta entry in connection data');
				}
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
	font-family: sans-serif;
}

#app {
	visibility: hidden;
	min-height: 100%;
	opacity: 0;
	transition: .4s;

	&.is-AppConnected {
		visibility: visible;
		opacity: 1;
	}
}

a {
	cursor: pointer;
	color: blue;
}

</style>
