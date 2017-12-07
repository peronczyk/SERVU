<template>

	<div class="c-LoginForm">

		<form @submit.prevent="login">
			<h4>Provide your credentials</h4>

			<label>
				<input type="email" name="email" placeholder="Email" v-model="formValues.email">
			</label>
			<label>
				<input type="password" name="password" placeholder="Password" v-model="formValues.password">
			</label>

			<button type="submit" class="u-Width--full">Login</button>
			<a @click.prevent="passwordRecovery">Password recovery</a>

			<p class="u-Error" v-if="loginErrorText">{{ loginErrorText }}</p>
		</form>

		<a class="c-LoginForm__appname" href="https://github.com/peronczyk/BROM" target="_blank">
			<span>Powered by:</span>
			BROM
		</a>
	</div>

</template>


<script>

import axios from 'axios';
import querystring from 'querystring';

export default {
	data() {
		return {
			formValues: {
				email: null,
				password: null,
			},
			loginErrorText: null
		}
	},

	methods: {
		login() {
			axios.post(window.appConfig.apiBaseUrl + 'users/login', querystring.stringify(this.formValues))
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
		},

		passwordRecovery() {
			this.$store.commit('openToast', 'This function is not available in this application version');
		}
	}
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

	form {
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
			color: $color-text-light;
		}
	}
}

</style>
