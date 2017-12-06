<template>

	<form @submit.prevent="login">
		<input type="email" name="email" placeholder="Email" v-model="formValues.email">
		<input type="password" name="password" placeholder="Password" v-model="formValues.password">
		<button type="submit">Login</button>
		<p v-if="loginErrorText">{{ loginErrorText }}</p>
	</form>

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
					}
				});
		}
	}
}

</script>
