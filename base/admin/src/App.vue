<template>

	<div id="app" v-if="$store.getters.isAppConnected" :class="{'is-UserLoggedIn': $store.getters.getUserAccess > 0}">
		<side-left />
		<side-right />
	</div>

</template>


<script>

import axios from 'axios';
import SideLeft from './components/SideLeft.vue';
import SideRight from './components/SideRight.vue';

export default {
	computed: {
	},

	created() {
		axios.get(window.appConfig.apiBaseUri)
			.then(result => {
				this.$store.commit('appConnected', result.data['app-info']);
			})
			.catch(error => {
				console.error('Application could not connect to api');
				console.log(error);
			});
	},

	components: { SideLeft, SideRight }
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

</style>
