<template>

	<div class="c-App" :class="{'is-AppConnected': $store.getters.isAppConnected, 'is-UserLoggedIn': $store.getters.getUserAccess > 0}">
		<the-sidebar />
		<the-main />
		<the-toast />
	</div>

</template>


<script>

import axios from 'axios';
import TheSidebar from './components/TheSidebar.vue';
import TheMain from './components/TheMain.vue';
import TheToast from './components/TheToast.vue';

export default {
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

	components: { TheSidebar, TheMain, TheToast }
}

</script>


<style lang="scss">

.c-App {
	visibility: hidden;
	position: relative;
	height: 100%;
	opacity: 0;
	overflow: hidden;
	transition: .4s;

	&.is-AppConnected {
		visibility: visible;
		opacity: 1;
	}
}

</style>
