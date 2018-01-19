<template>

	<div class="c-LoginForm">

		<div class="c-LoginForm__wrapper">
			<form @submit.prevent="login">
				<h4>Provide your credentials</h4>

				<form-field type="email" name="email" ref="email" :required="true">Email</form-field>
				<form-field type="password" name="password" ref="password" :required="true">Password</form-field>

				<button type="submit" class="u-Width--full">Login</button>

				<p class="u-Error" v-if="loginErrorText">{{ loginErrorText }}</p>
			</form>

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
import querystring from 'querystring';
import FormField from './elements/FormField.vue';

export default {
	data() {
		return {
			isFormValid: true,
			loginErrorText: null
		}
	},

	methods: {
		login() {
			this.isFormValid = true;

			let formData = {};

			for (let refName in this.$refs) {
				let ref = this.$refs[refName];
				formData[refName] = ref.fieldValue;

				if (!ref.validate()) {
					this.isFormValid = false;
				}
			}

			if (this.isFormValid) {
				axios.post(window.appConfig.apiBaseUrl + 'users/login', querystring.stringify(formData))
					.then(receivedData => {
						if (receivedData.data.errors) {
							this.loginErrorText = receivedData.data.errors[0].message;
						}
						else if (receivedData.data.status !== true) {
							this.loginErrorText = 'Login process failed';
							console.log(receivedData.data);
						}
						else {
							this.$store.commit('changeUserAccessLvl', receivedData.data.meta['access-lvl']);

							if (receivedData.data.meta['app-version']) {
								this.$store.commit('setAppVersion', receivedData.data.meta['app-version']);
							}
						}
					});
			}
			else {
				this.loginErrorText = 'Please fill in both login fields';
			}
		},

		passwordRecovery() {
			this.$store.commit('openToast', 'This function is not available in this application version');
		},
	},

	components: { FormField }
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
