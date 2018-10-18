<template>

	<div class="c-LoginForm">

		<div class="c-LoginForm__wrapper">
			<form-control
				:fields="loginFields"
				:uri="loginUri"
				:success="onSuccess"
				:error="onError"
				title="Provide your credentials"
				cta="Login"
			/>

			<a @click.prevent="passwordRecovery">Password recovery</a>
		</div>

		<a class="c-LoginForm__appname" href="https://github.com/peronczyk/servant" target="_blank">
			<span>Powered by:</span>
			Servant
		</a>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

// Components
import FormControl from './elements/FormControl.vue';
import FormField from './elements/FormField.vue';
import PasswordRecovery from './elements/PasswordRecovery.vue';

export default {
	components: {
		FormControl
	},

	data() {
		return {
			loginFields: [
				{
					type: 'email',
					name: 'email',
					label: 'Email address',
					required: true,
				},
				{
					type: 'password',
					name: 'password',
					label: 'Password',
					required: true,
				}
			],
			loginUri: window.appConfig.apiBaseUrl + 'users/login',
		}
	},

	methods: {
		...mapActions({
			handleReceivedMeta: 'base/handleReceivedMeta',
			openToast: 'toast/open',
			openModal: 'modal/open',
		}),

		onSuccess(result) {
			if (result.status === true) {
				this.handleReceivedMeta(result.meta);
			}
			else {
				this.openToast('API refuses to log you in because of unhandled error.');
			}
		},

		onError(error) {
			this.openToast((error.data.errors)
				? error.data.errors[0].message
				: 'Cannot connect to API'
			);
		},

		passwordRecovery() {
			this.openModal(PasswordRecovery);
		},
	},
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-LoginForm {
	position: relative;
	display: flex;
	align-items: center;
	height: 100vh;
	padding: var(--gutter-lg);

	&__wrapper {
		width: 100%;
		max-width: 300px;
	}

	&__appname {
		position: absolute;
		bottom: var(--gutter);
		right: var(--gutter);
		display: inline-block;
		padding: 10px;
		font-size: 12px;
		font-weight: bold;
		line-height: 1.4em;

		span {
			display: block;
			font-weight: normal;
			color: $color-text-lvl-2;
		}
	}
}

</style>
