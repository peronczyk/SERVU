<template>

	<transition name="fade">
		<div
			v-if="isConnected"
			:class="{
				'is-UserLoggedIn': isUserLoggedIn
			}"
			class="c-App"
		>
			<the-sidebar />
			<the-main />
			<the-dialog />
			<the-toast />
			<the-modal />

			<svg-icon-set />
		</div>
	</transition>

</template>


<script>

// Dependensies
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';

// Components
import TheSidebar from './components/TheSidebar.vue';
import TheMain from './components/TheMain.vue';
import TheDialog from './components/TheDialog.vue';
import TheToast from './components/TheToast.vue';
import TheModal from './components/TheModal.vue';

// Assets
import SvgIconSet from './assets/images/streamline-icons.svg';

export default {
	components: {
		TheSidebar, TheMain, TheDialog, TheToast, TheModal, SvgIconSet
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
	position: relative;
	min-height: 100%;
	overflow: hidden;
}

#StreamlineIcons {
	display: none;
}

</style>
