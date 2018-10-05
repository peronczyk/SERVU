<template>

	<div class="c-PasswordRecovery">
		<form-control
			:fields="[
				{
					type: 'email',
					name: 'email',
					label: 'Email address',
					required: true,
				}
			]"
			:uri="apiUri"
			:success="onSuccess"
			title="Password recovery"
			cta="Recover your password"
		/>
	</div>

</template>


<script>

// Dependencies
import { mapActions } from 'vuex';

// Components
import FormControl from './FormControl.vue';

export default {
	components: {
		FormControl,
	},

	data() {
		return {
			apiUri: window.appConfig.apiBaseUrl + 'users/recover'
		};
	},

	methods: {
		...mapActions({
			openToast: 'toast/open',
		}),

		onSuccess(resultData) {
			if (resultData.errors) {
				this.openToast(resultData.errors[0].message);
			}

			/**
			 * @todo
			 */
		},
	},
}

</script>