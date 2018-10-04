<template>

	<div
		class="c-App"
		:class="{
			'is-AppConnected': isConnected,
			'is-UserLoggedIn': isUserLoggedIn
		}"
	>
		<the-sidebar />
		<the-main />
		<the-toast />
		<the-modal />

		<svg-icon-set />
	</div>

</template>


<script>

// Dependensies
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';

// Components
import TheSidebar from './components/TheSidebar.vue';
import TheMain from './components/TheMain.vue';
import TheToast from './components/TheToast.vue';
import TheModal from './components/themodal.vue';

// Assets
import SvgIconSet from './assets/images/streamline-icons.svg';

export default {
	components: {
		TheSidebar, TheMain, TheToast, TheModal, SvgIconSet
	},

	computed: {
		...mapGetters({
			isConnected: 'base/isConnected',
			isUserLoggedIn: 'user/isLoggedIn',
		}),
	},

	methods: {
		...mapActions('base', [
			'handleReceivedMeta',
		]),
	},

	created() {
		axios.get(window.appConfig.apiBaseUrl)
			.then(result => {
				if (result.data.meta) {
					this.handleReceivedMeta(result.data.meta)
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
}

</script>


<style lang="scss">

.c-App {
	visibility: hidden;
	position: relative;
	min-height: 100%;
	opacity: 0;
	overflow: hidden;
	transition: .4s;

	&.is-AppConnected {
		visibility: visible;
		opacity: 1;
	}
}

#StreamlineIcons {
	display: none;
}

</style>
