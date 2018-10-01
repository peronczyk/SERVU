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

import axios from 'axios';
import FormControl from './elements/FormControl.vue';
import FormField from './elements/FormField.vue';

export default {
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
			loginErrorText: null,
		}
	},

	methods: {
		onSuccess(result) {
			if (result.errors) {
				this.loginErrorText = result.errors[0].message;
			}
			else if (result.status !== true) {
				this.loginErrorText = 'API refuses to log you in because of unhandled error.';
			}
			else {
				this.$store.commit('changeUserAccessLvl', result.meta['access-lvl']);

				if (result.meta) {
					this.$store.commit('setMeta', result.meta);
				}
			}
		},

		onError(error) {
			this.loginErrorText = 'Cannot connect to API';
		},

		passwordRecovery() {
			this.$store.commit('openToast', 'This function is not available in this application version');
		},
	},

	components: { FormControl }
}

</script>


<style lang="scss">

@import '../assets/styles/_variables';

.c-LoginForm {
	position: relative;
	display: flex;
	align-items: center;
	height: 100%;
	padding: $gutter * 3;

	&__wrapper {
		width: 100%;
		max-width: 300px;
	}

	&__appname {
		position: absolute;
		bottom: $gutter;
		right: $gutter;
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
